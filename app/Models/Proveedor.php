<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    // 👇 Especificar el nombre correcto de la tabla
    protected $table = 'proveedores';  // ← Con "e"
    
    protected $fillable = [
        'nit',
        'nombre',
        'telefono',
        'direccion',
        'correo'
    ];
}
