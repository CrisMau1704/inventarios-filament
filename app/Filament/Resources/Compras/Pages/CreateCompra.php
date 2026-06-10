<?php

namespace App\Filament\Resources\Compras\Pages;

use App\Filament\Resources\Compras\CompraResource;
use Filament\Resources\Pages\CreateRecord;
use App\Services\InventarioService;

class CreateCompra extends CreateRecord
{
    protected static string $resource = CompraResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Calcular total - Validar que detalles exista
        $total = 0;
        if (isset($data['detalles']) && is_array($data['detalles'])) {
            foreach ($data['detalles'] as &$detalle) {
                $subtotal = $detalle['cantidad'] * $detalle['precio_compra'];
                $detalle['subtotal'] = $subtotal;
                $total += $subtotal;
            }
        }
        $data['total'] = $total;
        
        return $data;
    }
    
    protected function afterCreate(): void
{
    // Calcular total desde la BD
    $total = $this->record->detalles()->sum('subtotal');

    $this->record->update([
        'total' => $total,
    ]);

    // Actualizar inventario
    foreach ($this->record->detalles as $detalle) {

        InventarioService::entrada(
            producto: $detalle->producto,
            cantidad: $detalle->cantidad,
            referencia: 'COMPRA',
            referenciaId: $this->record->id,
            observacion: "Compra de {$detalle->cantidad} unidades a Bs. {$detalle->precio_compra}"
        );
    }
}
}