<?php

namespace App\Filament\Resources\Ventas;

use App\Filament\Resources\Ventas\Pages\CreateVenta;
use App\Filament\Resources\Ventas\Pages\EditVenta;
use App\Filament\Resources\Ventas\Pages\ListVentas;
use App\Filament\Resources\Ventas\Schemas\VentaForm;
use App\Filament\Resources\Ventas\Tables\VentasTable;
use App\Models\Venta;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class VentasResource extends Resource
{
    protected static ?string $model = Venta::class;
    
    // 👇 CORREGIDO: Usar string con el nombre del icono
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static UnitEnum|string|null $navigationGroup = 'Ventas';
    
    protected static ?string $recordTitleAttribute = 'id';
    
    public static function form(Schema $schema): Schema
    {
        return VentaForm::configure($schema);
    }
    
    public static function table(Table $table): Table
    {
        return VentasTable::configure($table);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => ListVentas::route('/'),
            'create' => CreateVenta::route('/create'),
            'edit' => EditVenta::route('/{record}/edit'),
        ];
    }
}