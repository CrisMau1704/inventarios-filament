<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venta extends Model
{
    protected $table = 'ventas';
    
    protected $fillable = [
        'cliente_id',
        'fecha',
        'total',
        'estado'
    ];
    
    protected $casts = [
        'fecha' => 'date',
        'total' => 'decimal:2'
    ];
    
    // Relación con cliente
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
    
    // Relación con detalle de venta
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleVenta::class);
    }
}