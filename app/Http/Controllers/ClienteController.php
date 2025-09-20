<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::select('nombre')->get();
        return response()->json([
            'status'=>200,
            'message'=>'clientes obtenidos correctamente',
            'data'=>$clientes
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
        $cliente = new Cliente();
        $cliente->fill($request->all());
        if($cliente->save()) return response()->json([
            'status'=>201,
            'message'=>'Cliente creado exitosamente',
            'data'=>$cliente
        ],201);
        return response()->json([
            'status'=>500,
            'message'=>'No se pudo crear el cliente',
            'data'=>[]    
        ],500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
