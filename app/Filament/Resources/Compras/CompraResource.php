<?php

namespace App\Filament\Resources\Compras;

use App\Filament\Resources\Compras\Pages\CreateCompra;
use App\Filament\Resources\Compras\Pages\EditCompra;
use App\Filament\Resources\Compras\Pages\ListCompras;
use App\Models\Compra;
use Filament\Resources\Resource;
use UnitEnum;
use BackedEnum;

class CompraResource extends Resource
{
    // 👈 $model: DEBE tener ?string
    protected static ?string $model = Compra::class;
    
    // 👈 $navigationIcon: DEBE ser string|BackedEnum|null
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';
    
    // 👈 $navigationGroup: DEBE ser UnitEnum|string|null
    protected static UnitEnum|string|null $navigationGroup = 'Compras';
    
    // 👈 $navigationSort: PUEDE tener ?int
    protected static ?int $navigationSort = 2;

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return \App\Filament\Resources\Compras\Schemas\CompraForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return \App\Filament\Resources\Compras\Tables\ComprasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompras::route('/'),
            'create' => CreateCompra::route('/create'),
            'edit' => EditCompra::route('/{record}/edit'),
        ];
    }
}