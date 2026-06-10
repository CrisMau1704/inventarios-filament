<?php

namespace App\Filament\Resources\Ventas\Pages;

use App\Filament\Resources\Ventas\VentasResource;
use Filament\Resources\Pages\EditRecord;

class EditVenta extends EditRecord
{
    protected static string $resource = VentasResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        // Recargar los detalles actualizados
        $this->record->load('detalles');

        // Calcular total desde la tabla detalle_ventas
        $total = $this->record->detalles->sum('subtotal');

        // Actualizar total en ventas
        $this->record->update([
            'total' => $total,
        ]);
    }
}