<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return response()->json([
            'message' => 'categorias',
            'status' => 200,
            'data' => $categorias
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
            $categoria = Categoria::find($request->input('id'));
            if( $categoria ){
                $categoria->fill( $request->all() );
                if( $categoria->save() ){
                    return response()->json([
                        'message'=>'Categoría actualizada exitosamente',
                        'status'=>200,
                        'data'=>$categoria,
                    ],200);
                }else return response()->json([
                        'message'=>'Error al actualizar la categoría',
                        'status'=>500,
                        'data'=>[],
                    ], 500);
            }
            return response()->json([
                    'message'=>'No se encontró la categoría',
                    'status'=>500,
                    'data'=>[],
                ], 500);
        }

        // validaciones 
        $request->validate([ // LA CATEGORÍA ES OBLIGATORIA Y DEBE SER UNICA para evitar información duplicada
            'categoria' => 'required|unique:categorias,categoria'
        ]);
        // si no es crear
        $categoria = new Categoria();
        $categoria->fill( $request->all() );
        if ( $categoria->save() ) return response()->json([
                'message'=>'Categoría creada exitosamente',
                'status'=>201,
                'data'=>$categoria,
            ],201);
        else return response()->json([
                'message'=>'Error al crear la categoría',
                'status'=>500,
                'data'=>[],
            ],500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        //
    }
}
