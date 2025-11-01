<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Resources\ProductoResource;
use App\Http\Requests\ProductoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $producto = Producto::all();

        return response()->json([
            'message' => 'Productos',
            'status' => 200,
            'data' => ProductoResource::collection($producto)
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

    public function store(ProductoRequest $request): ?JsonResponse
    {
        $validated = $request->validated();

        $user = Auth::id();
        $producto = Producto::create([
            "created_by" => $user,
            "updated_by" => $user,
            ...$validated
        ]);

        return response()->json([
            "message" => "Producto creado exitosamente",
            "data" => new ProductoResource($producto)
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {

        $producto->update($request->all());

        return response()->json([
            "message" => "Producto actualizado exitosamente",
            "data" => new ProductoResource($producto->fresh())
        ], Response::HTTP_OK);
    }

    #region codigo ejemplo guardar imagen
    //         // Procesar imagen si se está subiendo
    //         if ($request->hasFile('imagen')) {
    //             // Eliminar la imagen anterior si existe
    //             if ($producto->imagen) {
    //                 $imagenAnterior = public_path(parse_url($producto->imagen, PHP_URL_PATH));
    //                 if (file_exists($imagenAnterior)) {
    //                     unlink($imagenAnterior);
    //                 }
    //             }

    //             // Subir la nueva imagen
    //             $file = $request->file('imagen');
    //             $filename = time() . '_' . $file->getClientOriginalName();
    //             $file->move(public_path('imagenes'), $filename);
    //             $producto->imagen = asset('imagenes/' . $filename);
    //         }

    //     $filename = null;

    //     if ($request->hasFile('imagen')) {
    //         $file = $request->file('imagen');
    //         $filename = time() . '_' . $file->getClientOriginalName();
    //         $file->move(public_path('imagenes'), $filename);
    //     }

    //     $producto = new Producto();
    //     $producto->fill($request->except('imagen'));

    //     if ($filename) {
    //         $producto->imagen = asset('imagenes/' . $filename);
    //     }
    #endregion
}
