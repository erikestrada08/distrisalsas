<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'codigo_barra' => $this->codigo_barra,
            'marca_id' => $this->marca_id,
            'marca' => $this->marca->marca,
            'categoria_id' => $this->categoria_id,
            'categoria' => $this->categoria->categoria,
            'precio' => $this->precio,
            'costo' => $this->costo,
            'activo' => $this->activo,
            'atributos' => $this->atributos
        ];
    }
}
