<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'razon_social',
        'nit',
        'direccion',
        'email',
        'observaciones'
    ];
}
