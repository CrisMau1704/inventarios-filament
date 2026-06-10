<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';
    
    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio_venta',
        'subtotal'
    ];
    
    protected $casts = [
        'cantidad' => 'integer',
        'precio_venta' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];
    
    // Relación con venta
    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }
    
    // Relación con producto
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}