<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'marca_id',
        'categoria_id',
        'producto',
        'descripcion',
        'activo'
    ];
    protected $casts = [
        'marca_id' => 'integer',
        'categoria_id' => 'integer',
        'activo' => 'boolean',
    ];

    public function variantes(): HasMany {
        return $this->hasMany(Variante::class, 'producto_id');
    }
}
