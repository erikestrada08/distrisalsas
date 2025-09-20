<?php

namespace App\Http\Controllers;

use App\Models\MovimientoInventario;
use App\Models\Producto;
use App\Models\Variante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Validar datos de entrada
        $validated = $request->validate([
            '*.id'       => 'required|exists:variantes,id',
            '*.unidades' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {
            foreach ($validated as $item) {
                // 1. Buscar producto
                $producto = Variante::find($item['id']);
                Log::debug($producto);

                // 2. Actualizar stock
                $producto->stock_actual += $item['unidades'];
                $producto->save();

                // 3. Registrar movimiento
                MovimientoInventario::create([
                    'variante_id' => $producto->id,
                    'tipo' => 'ENTRADA',
                    'cantidad' => $item['unidades'],
                    'usuario_id' => $request->user()->id
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Entrada de inventario registrada correctamente',
            ], 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al registrar entrada',
                'error'   => $th->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
