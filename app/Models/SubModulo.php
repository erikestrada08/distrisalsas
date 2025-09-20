<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubModulo extends Model
{
    protected $table = 'sub_modulos';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'sub_modulo',
        'abreviatura',
        'modulo_id',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'modulo_id' => 'integer'
    ];
}
