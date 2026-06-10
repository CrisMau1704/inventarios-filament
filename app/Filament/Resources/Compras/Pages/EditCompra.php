<?php

namespace App\Filament\Resources\Compras\Pages;

use App\Filament\Resources\Compras\CompraResource;
use Filament\Resources\Pages\EditRecord;

class EditCompra extends EditRecord
{
    protected static string $resource = CompraResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        // Recargar relación
        $this->record->load('detalles');

        // Calcular total desde detalle_compras
        $total = $this->record->detalles->sum('subtotal');

        // Actualizar compra
        $this->record->update([
            'total' => $total,
        ]);
    }
}