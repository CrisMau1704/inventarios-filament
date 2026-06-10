<?php

namespace App\Filament\Resources\Ventas\Pages;

use App\Filament\Resources\Ventas\VentasResource;
use Filament\Resources\Pages\CreateRecord;
use App\Services\InventarioService;

class CreateVenta extends CreateRecord
{
    protected static string $resource = VentasResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['total'] = 0;

        return $data;
    }

    protected function afterCreate(): void
    {
        $total = $this->record
            ->detalles()
            ->sum('subtotal');

        $this->record->update([
            'total' => $total,
        ]);

        foreach ($this->record->detalles as $detalle) {
            InventarioService::salida(
                producto: $detalle->producto,
                cantidad: $detalle->cantidad,
                referencia: 'VENTA',
                referenciaId: $this->record->id,
                observacion: "Venta de {$detalle->cantidad} unidades"
            );
        }
    }
}