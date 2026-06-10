<?php

namespace App\Filament\Resources\Ventas\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class VentasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('N° Venta')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('cliente.nombre')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                    
                TextColumn::make('total')
                    ->label('Total')
                    ->money('BOB')
                    ->sortable(),
                    
                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'COMPLETADA' => 'success',
                        'PENDIENTE' => 'warning',
                        'ANULADA' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'COMPLETADA' => 'Completada',
                        'PENDIENTE' => 'Pendiente',
                        'ANULADA' => 'Anulada',
                        default => $state,
                    }),
                    
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),  // Botón eliminar individual
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),  // Eliminación masiva
                ]),
            ]);
    }
}