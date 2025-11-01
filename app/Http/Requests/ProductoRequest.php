<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "nombre" => "required|string",
            "descripcion" => "nullable|string",
            "codigo_barra" => "nullable|string|unique:productos,codigo_barra",
            "marca_id" => "required|exists:marcas,id",
            "categoria_id" => "required|exists:categorias,id",
            "precio" => "required|decimal:0,2",
            "costo" => "decimal:0,2",
            "atributos" => "nullable|array",
            "activo" => "boolean",
        ];
    }

    public function attributes(): array
    {
        return [
            "nombre" => "nombre",
            "descripcion" => "descripción",
            "codigo_barra" => "código de barras",
            "marca_id" => "marca",
            "categoria_id" => "categoría",
            "precio" => "precio",
            "costo" => "costo",
            "atributos" => "atributos",
            "activo" => "activo",
        ];
    }
}
