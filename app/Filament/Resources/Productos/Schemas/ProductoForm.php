<?php

namespace App\Filament\Resources\Productos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\Categoria; // Asegúrate de importar tu modelo de categoría

class ProductoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codigo')
                    ->required(),
                Select::make('categoria_id')
                    ->label('Categoría')
                    ->relationship('categoria', 'nombre') // Si tienes la relación definida
                    ->required()
                    ->searchable()
                    ->preload(),
                // O alternativamente, si no tienes la relación:
                // Select::make('categoria_id')
                //     ->label('Categoría')
                //     ->options(Categoria::pluck('nombre', 'id'))
                //     ->required()
                //     ->searchable()
                //     ->preload(),
                TextInput::make('nombre')
                    ->required(),
                Textarea::make('descripcion')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('precio_compra')
                    ->required()
                    ->numeric(),
                TextInput::make('precio_venta')
                    ->required()
                    ->numeric(),
                TextInput::make('stock_actual')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('stock_minimo')
                    ->required()
                    ->numeric()
                    ->default(1),
                Toggle::make('estado')
                    ->required(),
            ]);
    }
}