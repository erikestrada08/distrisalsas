<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = Marca::all();
        return response()->json([
            'message' => 'Marcas',
            'status' => 200,
            'data' => $marcas
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
                // si viene id es actualizar
        if($request->input('id')){
            $marca = Marca::find($request->input('id'));
            if( $marca ){
                $marca->fill( $request->all() );
                if( $marca->save() ){
                    return response()->json([
                        'message'=>'Marca actualizada exitosamente',
                        'status'=>200,
                        'data'=>$marca,
                    ],200);
                }else return response()->json([
                        'message'=>'Error al actualizar la marca',
                        'status'=>500,
                        'data'=>[],
                    ], 500);
            }
            return response()->json([
                    'message'=>'No se encontró la marca',
                    'status'=>500,
                    'data'=>[],
                ], 500);
        }

        // validaciones 
        $request->validate([ // LA CATEGORÍA ES OBLIGATORIA Y DEBE SER UNICA para evitar información duplicada
            'marca' => 'required|unique:marcas,marca'
        ]);
        // si no es crear
        $marca = new Marca();
        $marca->fill( $request->all() );
        if ( $marca->save() ) return response()->json([
                'message'=>'Marca creada exitosamente',
                'status'=>201,
                'data'=>$marca,
            ],201);
        else return response()->json([
                'message'=>'Error al crear la marca',
                'status'=>500,
                'data'=>[],
            ],500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Marca $marca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marca $marca)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marca $marca)
    {
        //
    }
}
