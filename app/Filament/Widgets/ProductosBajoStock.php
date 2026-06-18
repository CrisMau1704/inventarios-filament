<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Producto;

class ProductosBajoStock extends BaseWidget
{
    protected static ?int $sort = 3;
    
    protected function getHeading(): string
    {
        return '⚠️ Productos con Stock Bajo';
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Producto::query()
                    ->whereColumn('stock_actual', '<=', 'stock_minimo')
                    ->where('estado', true)
                    ->orderBy('stock_actual', 'asc')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Producto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock_actual')
                    ->label('Stock')
                    ->numeric()
                    ->color('danger'),
                Tables\Columns\TextColumn::make('stock_minimo')
                    ->label('Mínimo')
                    ->numeric(),
                Tables\Columns\TextColumn::make('necesita')
                    ->label('Faltante')
                    ->getStateUsing(fn ($record) => max(0, $record->stock_minimo - $record->stock_actual))
                    ->numeric()
                    ->color('danger'),
            ]);
            // 👈 Sin acciones por ahora
    }
}