<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\MovimientoInventario;

class UltimosMovimientos extends BaseWidget
{
    protected static ?int $sort = 4;
    
    protected function getHeading(): string
    {
        return '🔄 Últimos movimientos de inventario';
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                MovimientoInventario::query()
                    ->with('producto', 'usuario')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('producto.nombre')
                    ->label('Producto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'COMPRA' => 'success',
                        'VENTA' => 'danger',
                        'AJUSTE' => 'warning',
                        'DEVOLUCION' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('cantidad')
                    ->label('Cantidad')
                    ->numeric(),
                Tables\Columns\TextColumn::make('stock_anterior')
                    ->label('Stock anterior')
                    ->numeric(),
                Tables\Columns\TextColumn::make('stock_nuevo')
                    ->label('Stock nuevo')
                    ->numeric(),
                Tables\Columns\TextColumn::make('referencia')
                    ->label('Referencia')
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}