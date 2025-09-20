<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variante extends Model
{
    use HasFactory;
    
    protected $table = 'variantes';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'producto_id',
        'codigo_barra',
        'atributos_json',
        'precio_venta',
        'costo',
        'stock_minimo',
        'stock_maximo',
        'imagen',
        'stock_actual',
        'activo'
    ];
    protected $casts = [];
}
