<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Feature\Type;

class AiController extends Controller
{
    private function parseOcrTexto(string $texto): array
    {
        if (!$texto) return [];
        $prompt = $this->construirPrompt();
        $hash = md5($texto);
        $cacheKey = "factura_parse_{$hash}";
        $ttl = now()->addDays(7);

        return Cache::remember($cacheKey, $ttl, function () use ($prompt, $texto) {
            $provider = strtolower((string) env('AI_PROVIDER', 'gemini'));
            $fallback = filter_var(env('AI_FALLBACK', true), FILTER_VALIDATE_BOOL);
            $respuesta = null;

            if ($provider === 'openai') {
                $respuesta = $this->procesarConChatGpt($prompt, $texto);
                if ((!is_array($respuesta) || empty($respuesta)) && $fallback) {
                    $respuesta = $this->procesarConGemini($prompt, $texto);
                }
            } else { // gemini por defecto
                $respuesta = $this->procesarConGemini($prompt, $texto);
                if ((!is_array($respuesta) || empty($respuesta)) && $fallback) {
                    $respuesta = $this->procesarConChatGpt($prompt, $texto);
                }
            }

            if (!is_array($respuesta)) $respuesta = [];

            // Normalización ligera y relleno seguro
            $respuesta['productos'] = array_map(function ($p) {
                $unidades = isset($p['unidades']) ? abs((float)$p['unidades']) : 0;
                $precio = isset($p['precio_unitario']) ? abs((float)$p['precio_unitario']) : 0;
                $p['unidades'] = $unidades;
                $p['precio_unitario'] = $precio;
                if (!isset($p['precio_total'])) {
                    $p['precio_total'] = (float)($unidades * $precio);
                }
                return $p;
            }, $respuesta['productos'] ?? []);

            if (isset($respuesta['iva_incluido'])) {
                $val = $respuesta['iva_incluido'];
                $respuesta['iva_incluido'] = filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            }

            return $respuesta;
        });
    }

    private function extraerDatosFactura($texto)
    {
        if (!$texto) return response()->json(['message' => 'Texto OCR requerido.', 'status' => 422, 'data' => []], 422);
        $data = $this->parseOcrTexto($texto);
        if (!$data) {
            $data = [
                'proveedor' => null,
                'nit_proveedor' => null,
                'fecha_emision' => null,
                'productos' => [],
                'iva_incluido' => null,
            ];
        }
        return response()->json($data, 200);
    }

    public function convertirImagenATexto(Request $request){
        $request->validate([
            'factura' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);
        $path = $request->file('factura')->store('ocr_tmp');
        // Obtener la ruta física del archivo según el disk configurado
        $imagePath = Storage::path($path);
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . env('GOOGLE_APPLICATION_CREDENTIALS'));
        $vision = new ImageAnnotatorClient();
        $imageContent = file_get_contents($imagePath);
        $image = (new Image())->setContent($imageContent);
        $feature = (new Feature())->setType(Type::DOCUMENT_TEXT_DETECTION);
        $requestObj = (new AnnotateImageRequest())->setImage($image)->setFeatures([$feature]);
        $batchRequest = (new BatchAnnotateImagesRequest())->setRequests([$requestObj]);
        $response = $vision->batchAnnotateImages($batchRequest);
        $vision->close();
        Storage::delete($path);
        $annotation = $response->getResponses()[0]->getFullTextAnnotation();
        $texto = $annotation ? $annotation->getText() : '';

        try {
            return $this->extraerDatosFactura($texto);
        } catch (\Throwable $th) {
            return response()->json($th,500);
        }
    }

    public function convertirMultiplesImagenesATexto(Request $request){
        $request->validate([
            'facturas' => 'required',
            'facturas.*' => 'image|mimes:jpg,jpeg,png|max:5120'
        ]);

        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . env('GOOGLE_APPLICATION_CREDENTIALS'));
        $vision = new ImageAnnotatorClient();

        $resultados = [];
        foreach ($request->file('facturas', []) as $archivo) {
            $path = $archivo->store('ocr_tmp');
            $imagePath = Storage::path($path);
            $imageContent = file_get_contents($imagePath);
            $image = (new Image())->setContent($imageContent);
            $feature = (new Feature())->setType(Type::DOCUMENT_TEXT_DETECTION);
            $requestObj = (new AnnotateImageRequest())->setImage($image)->setFeatures([$feature]);
            $batchRequest = (new BatchAnnotateImagesRequest())->setRequests([$requestObj]);
            $response = $vision->batchAnnotateImages($batchRequest);
            Storage::delete($path);

            $annotation = $response->getResponses()[0]->getFullTextAnnotation();
            $texto = $annotation ? $annotation->getText() : '';
            $data = $this->parseOcrTexto($texto);
            if (!$data) {
                $data = [
                    'proveedor' => null,
                    'nit_proveedor' => null,
                    'fecha_emision' => null,
                    'productos' => [],
                    'iva_incluido' => null,
                ];
            }
            $resultados[] = $data;
        }

        $vision->close();
        return response()->json($resultados, 200);
    }

    private function obtenerProductosComunes(): string {
        $productos = DB::table('movimientos_inventario as m')
            ->join('variantes as v', 'm.variante_id', '=', 'v.id')
            ->join('productos as p', 'v.producto_id', '=', 'p.id')
            ->join('marcas as ma', 'p.marca_id', '=', 'ma.id')
            ->select(
                'v.id', 'p.producto', 'v.atributos_json as atributos', 'ma.marca',
                DB::raw('SUM(m.cantidad) as total_vendido')
            )
            ->where('m.tipo', 'SALIDA')
            ->where('m.created_at', '>=', Carbon::now()->subMonths(2))
            ->groupBy('v.id', 'p.producto', 'v.atributos_json', 'ma.marca')
            ->orderByDesc('total_vendido')
            ->limit(10)
            ->get();

        return $productos->map(function ($item) {
            $atributos = json_decode($item->atributos, true);
            $nombre = "id:{$item->id} " . strtolower(trim($item->producto)) . ' ' . strtolower(trim($item->marca));
            if (is_array($atributos)) {
                foreach ($atributos as $valor) {
                    $nombre .= ' ' . strtolower(trim($valor));
                }
            }
            return $nombre;
        })->implode("\n");
    }

    private function obtenerProveedoresComunes(): string {
        return Proveedor::take(5)->get()->map(function ($proveedor) {
            $atributos = json_decode($proveedor->atributos, true) ?? [];
            $nombre = "id:{$proveedor->id} " . strtolower(trim($proveedor->razon_social)) . ' ' . strtolower(trim($proveedor->nit));
            foreach ($atributos as $valor) {
                $nombre .= ' ' . strtolower(trim($valor));
            }
            return $nombre;
        })->implode("\n");
    }


    private function construirPrompt(): string {
        $productosComunes = $this->obtenerProductosComunes();
        $proveedoresComunes = $this->obtenerProveedoresComunes();
        Log::debug($productosComunes);
        return <<<PROMPT
            Eres un sistema experto en lectura y comprensión de facturas OCR en español. Se te proporcionará:
            1. Texto plano de una factura (sin estructura clara, con errores de OCR).
            2. Un catálogo de productos conocidos, con ID, nombre, marca y atributos.
            Tu objetivo es:
            ✅ Leer los productos en la factura.
            ✅ Buscar coincidencias o similitudes en el catálogo.
            ✅ Para cada coincidencia, devolver el producto del catálogo con su `id` y nombre exacto.
            ✅ Incluir también `unidades` y `precio_unitario` detectados.
            📦 Catálogo de productos comunes: $productosComunes
            📦 Lista de proveedores comunes: $proveedoresComunes
            📅 Formatos de fecha válidos: ['dd/mm/yyyy', 'dd-mm-yyyy', 'yyyy-mm-dd']
            💰 Palabras clave comunes para impuestos: ['IVA', 'Impuesto', 'Valor Agregado']
            📄 Ejemplo JSON esperado:
            {
                "proveedor": "Droguería Cafam S.A.",
                "nit_proveedor": "900123456-7",
                "fecha_emision": "2024-05-15",
                "productos": [
                    {
                        "id": 42,
                        "nombre": "Contenedor térmico 16 oz tapa dentro",
                        "unidades": 50, (cantidad en unidades si aplica, si no null)
                        "precio_unitario": 10200,
                        "precio_total": (unidades * precio_unitario)
                    }
                ],
                "iva_incluido": false, (definir si la factura es iva incluido o es mas iva)
            }
            IMPORTANTE:
            - No generes texto adicional, solo devuelve un objeto JSON.
            - Si un producto se parece a uno del catálogo, siempre usa su `id` y `nombre` del catálogo.
            - Si un producto no coincide con ninguno del catálogo,No lo incluyas
            - Siempre especifica la cantidad en unidades, en caso de no detectar, establecer en 0.
            - Recuerda que NO pueden haber valores negativos, todo es en valor absoluto.
            PROMPT;
    }

    private function procesarConGemini(string $prompt, string $textoOcr): ?array {
        $apiKey = env('GEMINI_API_KEY');
        $endpoint = "https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $response = Http::post($endpoint, [
            'contents' => [[
                'parts' => [
                    ['text' => $prompt],
                    ['text' => $textoOcr]
                ]
            ]]
        ]);

        if (!$response->successful()) return null;

        $jsonText = data_get($response->json(), 'candidates.0.content.parts.0.text', '');
        $jsonText = preg_replace('/^```json|```$/i', '', trim($jsonText));
        $jsonDecoded = json_decode($jsonText, true);

        return json_last_error() === JSON_ERROR_NONE ? $jsonDecoded : null;
    }

    private function procesarConChatGpt(string $prompt, string $textoOcr): array {
        $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => $prompt],
                ['role' => 'user', 'content' => $textoOcr],
            ],
            'temperature' => 0.2,
        ]);

        $text = $response->json('choices.0.message.content', '{}');
        return json_decode($text, true);
    }
}
