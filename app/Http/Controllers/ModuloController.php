<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use Illuminate\Http\Request;

class ModuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modulos = Modulo::all();
        return response()->json([
            'status'=>200,
            'message'=>'modulos obtenidos correctamente',
            'data'=>$modulos
        ],200);
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
        $request->validate([
            'nombre'=>'required',
            'icono'=>'required'
        ]);

        $modulo = new Modulo();
        $modulo->fill($request->all());
        if($modulo->save()) return response()->json([
                'status'=>201,
                'message'=>'Modulo creado correctamente',
                'data'=>$modulo
            ],201);
        return response()->json([
            'status'=>500,
            'message'=>'El modulo NO creado correctamente',
            'data'=>[]
        ],500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Modulo $modulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modulo $modulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modulo $modulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modulo $modulo)
    {
        //
    }
}
