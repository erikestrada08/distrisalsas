<?php

namespace App\Http\Controllers;

use App\Models\SubModulo;
use Illuminate\Http\Request;

class SubModuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subModulos = SubModulo::where([
            'modulo_id' => $request->input('modulo')
        ])->get();

        return response()->json([
            'message' => 'Submodulos',
            'status' => 200,
            'data' => $subModulos
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SubModulo $subModulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubModulo $subModulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubModulo $subModulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubModulo $subModulo)
    {
        //
    }
}
