<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    //
    protected $table = 'movimientos_inventario';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'variante_id', 'tipo', 'cantidad', 'usuario_id'
    ];
    protected $casts = [
        'marca_id' => 'integer',
        'categoria_id' => 'integer',
        'activo' => 'boolean',
    ];
}
