<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo_barra',
        'marca_id',
        'categoria_id',
        'created_by',
        'updated_by',
        'precio',
        'costo',
        'activo',
        'atributos'
    ];
    protected $casts = [
        'nombre' => 'string',
        'descripcion' => 'string',
        'codigo_barras' => 'string',
        'marca_id' => 'integer',
        'categoria_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'precio' => 'float',
        'costo' => 'float',
        'activo' => 'boolean',
        'atributos' => 'array',
    ];

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function createdAt(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updatedAt(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
