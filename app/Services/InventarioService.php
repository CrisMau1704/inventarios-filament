<?php

namespace App\Services;

use App\Models\Producto;
use App\Models\MovimientoInventario;
use Illuminate\Support\Facades\Auth;

class InventarioService
{
    /**
     * Registrar entrada de inventario (COMPRA)
     */
    public static function entrada(
        Producto $producto, 
        int $cantidad, 
        string $referencia, 
        ?int $referenciaId = null, 
        ?string $observacion = null
    ): void {
        $stockAnterior = $producto->stock_actual ?? 0;
        $stockNuevo = $stockAnterior + $cantidad;
        
        // Actualizar stock del producto
        $producto->stock_actual = $stockNuevo;
        $producto->save();
        
        // Registrar movimiento - Usar 'COMPRA' que existe en el ENUM
        MovimientoInventario::create([
            'producto_id' => $producto->id,
            'tipo' => 'COMPRA',  // 👈 Cambiado de 'ENTRADA' a 'COMPRA'
            'cantidad' => $cantidad,
            'stock_anterior' => $stockAnterior,
            'stock_nuevo' => $stockNuevo,
            'referencia' => $referencia . ($referenciaId ? " #{$referenciaId}" : ''),
            'observacion' => $observacion,
            'user_id' => Auth::id()
        ]);
    }
    
    /**
     * Registrar salida de inventario (VENTA)
     */
    public static function salida(
        Producto $producto, 
        int $cantidad, 
        string $referencia, 
        ?int $referenciaId = null, 
        ?string $observacion = null
    ): void {
        $stockAnterior = $producto->stock_actual ?? 0;
        $stockNuevo = max(0, $stockAnterior - $cantidad);
        
        // Actualizar stock del producto
        $producto->stock_actual = $stockNuevo;
        $producto->save();
        
        // Registrar movimiento - Usar 'VENTA' que existe en el ENUM
        MovimientoInventario::create([
            'producto_id' => $producto->id,
            'tipo' => 'VENTA',  // 👈 Cambiado de 'SALIDA' a 'VENTA'
            'cantidad' => $cantidad,
            'stock_anterior' => $stockAnterior,
            'stock_nuevo' => $stockNuevo,
            'referencia' => $referencia . ($referenciaId ? " #{$referenciaId}" : ''),
            'observacion' => $observacion,
            'user_id' => Auth::id()
        ]);
    }
}