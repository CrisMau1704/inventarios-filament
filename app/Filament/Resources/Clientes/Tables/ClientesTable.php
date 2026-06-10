<?php

namespace App\Filament\Resources\Clientes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;  
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nit_ci')->searchable(),
                TextColumn::make('nombre')->searchable(),
                TextColumn::make('telefono')->searchable(),
                TextColumn::make('direccion')->searchable(),
                TextColumn::make('correo')->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([  // ← Nombre correcto para v4
                EditAction::make(),
                DeleteAction::make(),  // ← Botón eliminar individual
            ])
            ->toolbarActions([  // ← Nombre correcto para v4
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}