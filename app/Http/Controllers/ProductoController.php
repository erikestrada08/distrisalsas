<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $producto = Producto::with('variantes')->get();
        // obtener los productos completos con la info de la variante
        return response()->json([
            'message' => 'Productos',
            'status' => 200,
            'data' => $producto
        ]);
    }

    /**
     * Listar los productos que se muestran en el catalogo
     */
    public function list()
    {
        $productos = Producto::where([ 'activo' => 1 ])->get();
        return response()->json([
            'message' => 'Productos',
            'status' => 200,
            'data' => $productos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $productoId = $request->input('id');

        // Convierte 'true' o 'false' del frontend (como string) a boolean real
        $request->merge([
            'activo' => filter_var($request->input('activo'), FILTER_VALIDATE_BOOLEAN),
        ]);


        if ($productoId) {
            $producto = Producto::find($productoId);

            if (!$producto) {
                return response()->json([
                    'message' => 'Producto no encontrado',
                    'status' => 404,
                ], 404);
            }

            // Procesar imagen si se está subiendo
            if ($request->hasFile('imagen')) {
                // Eliminar la imagen anterior si existe
                if ($producto->imagen) {
                    $imagenAnterior = public_path(parse_url($producto->imagen, PHP_URL_PATH));
                    if (file_exists($imagenAnterior)) {
                        unlink($imagenAnterior);
                    }
                }

                // Subir la nueva imagen
                $file = $request->file('imagen');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('imagenes'), $filename);
                $producto->imagen = asset('imagenes/' . $filename);
            }

            // Llenar los demás campos (sin sobreescribir imagen)
            $producto->fill($request->except('imagen'));


            if ($producto->save()) {
                return response()->json([
                    'message' => 'Producto actualizado exitosamente',
                    'status' => 200,
                    'data' => $producto
                ]);
            }

            return response()->json([
                'message' => 'Error al actualizar el producto',
                'status' => 500
            ], 500);
        }


        // Validación para creación
        $request->validate([
            'producto' => 'required|min:5|unique:productos,producto'
        ]);

        $filename = null;

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('imagenes'), $filename);
        }

        $producto = new Producto();
        $producto->fill($request->except('imagen'));

        if ($filename) {
            $producto->imagen = asset('imagenes/' . $filename);
        }

        if ($producto->save()) {
            return response()->json([
                'message' => 'Producto creado exitosamente',
                'status' => 201,
                'data' => $producto
            ], 201);
        }

        return response()->json([
            'message' => 'No se pudo crear el producto',
            'status' => 500,
            'data' => []
        ], 500);
    }


    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
