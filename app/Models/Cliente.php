<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nit_ci',
        'nombre',
        'telefono',
        'direccion',
        'correo',
    ];

    public function venta()
    {
        return $this->hasMany(Venta::class);
    }


}
