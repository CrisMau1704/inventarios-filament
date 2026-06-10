<?php

namespace App\Filament\Resources\Compras\Pages;

use App\Filament\Resources\Compras\CompraResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListCompras extends ListRecords
{
    protected static string $resource = CompraResource::class;
    
    // 👇 Este método agrega el botón "Nueva Compra"
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nueva Compra')
                ->icon('heroicon-o-plus'),
        ];
    }
}