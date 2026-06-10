<?php

namespace App\Filament\Resources\Compras\Schemas;

use App\Models\Producto;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CompraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('proveedor_id')
                    ->label('Proveedor')
                    ->relationship('proveedor', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('fecha')
                    ->label('Fecha')
                    ->default(now())
                    ->required(),

                Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'PENDIENTE' => 'Pendiente',
                        'COMPLETADA' => 'Completada',
                        'ANULADA' => 'Anulada',
                    ])
                    ->default('COMPLETADA')
                    ->required(),

                Repeater::make('detalles')
                    ->label('Productos')
                    ->relationship('detalles')
                    ->schema([

                        Select::make('producto_id')
                            ->label('Producto')
                            ->options(fn () => Producto::pluck('nombre', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {

                                $producto = Producto::find($state);

                                if ($producto) {

                                    $cantidad = (float) ($get('cantidad') ?? 1);

                                    $set('precio_compra', $producto->precio_compra);

                                    $set(
                                        'subtotal',
                                        $producto->precio_compra * $cantidad
                                    );
                                }
                            }),

                        TextInput::make('cantidad')
                            ->label('Cantidad')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {

                                $precio = (float) ($get('precio_compra') ?? 0);

                                $set(
                                    'subtotal',
                                    $precio * (float) $state
                                );
                            }),

                        TextInput::make('precio_compra')
                            ->label('Precio Compra')
                            ->numeric()
                            ->prefix('Bs.')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {

                                $cantidad = (float) ($get('cantidad') ?? 1);

                                $set(
                                    'subtotal',
                                    (float) $state * $cantidad
                                );
                            }),

                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->numeric()
                            ->prefix('Bs.')
                            ->readOnly()
                            ->dehydrated(true),

                    ])
                    ->columns(4)
                    ->columnSpanFull()
                    ->defaultItems(1)
                    ->addActionLabel('Agregar producto')
                    ->live(),

                Placeholder::make('total_mostrado')
                    ->label('Total General')
                    ->content(function (callable $get) {

                        $detalles = $get('detalles') ?? [];

                        $total = collect($detalles)->sum(
                            fn ($item) => (float) ($item['subtotal'] ?? 0)
                        );

                        return 'Bs. ' . number_format($total, 2);
                    })
                    ->live(),

                TextInput::make('total')
                    ->hidden()
                    ->dehydrated(true)
                    ->default(0),

            ]);
    }
}