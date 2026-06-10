<?php

namespace App\Filament\Resources\Ventas\Schemas;

use App\Models\Producto;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VentaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('cliente_id')
                    ->label('Cliente')
                    ->relationship('cliente', 'nombre')
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
                            ->options(
                                Producto::query()
                                    ->pluck('nombre', 'id')
                                    ->toArray()
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {

                                $producto = Producto::find($state);

                                if ($producto) {

                                    $set('precio_venta', $producto->precio_venta);

                                    $cantidad = (float) ($get('cantidad') ?: 1);

                                    $set(
                                        'subtotal',
                                        $cantidad * (float) $producto->precio_venta
                                    );
                                }
                            }),

                        TextInput::make('cantidad')
                            ->label('Cantidad')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {

                                $precio = (float) ($get('precio_venta') ?: 0);

                                $set(
                                    'subtotal',
                                    ((float) $state) * $precio
                                );
                            }),

                        TextInput::make('precio_venta')
                            ->label('Precio Unitario')
                            ->numeric()
                            ->prefix('Bs.')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {

                                $cantidad = (float) ($get('cantidad') ?: 1);

                                $set(
                                    'subtotal',
                                    $cantidad * ((float) $state)
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
                    ->addActionLabel('Agregar otro producto')
                    ->live(),

                Placeholder::make('total_general')
                    ->label('Total General')
                    ->content(function (callable $get) {

                        $detalles = $get('detalles') ?? [];

                        $total = collect($detalles)->sum(function ($item) {
                            return (float) ($item['subtotal'] ?? 0);
                        });

                        return 'Bs. ' . number_format($total, 2);
                    }),

            ]);
    }
}