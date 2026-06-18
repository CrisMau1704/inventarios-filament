<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Cliente;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;  // 👈 Corregido
    
    protected function getStats(): array
    {
        return [
            Stat::make('Ventas Hoy', Venta::whereDate('created_at', Carbon::today())->count())
                ->description('Total de ventas del día')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 3, 4, 5, 6, 4, 8])
                ->color('success')
                ->extraAttributes([
                    'class' => 'shadow-lg rounded-xl transition-all duration-300 hover:scale-105'
                ]),
                
            Stat::make('Ingresos Hoy', 'Bs. ' . number_format(Venta::whereDate('created_at', Carbon::today())->sum('total'), 2))
                ->description('Total recaudado')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->chart([5, 6, 7, 8, 9, 10, 12])
                ->color('warning')
                ->extraAttributes([
                    'class' => 'shadow-lg rounded-xl transition-all duration-300 hover:scale-105'
                ]),
                
            Stat::make('Productos', Producto::where('estado', true)->count())
                ->description('Productos activos')
                ->descriptionIcon('heroicon-m-cube')
                ->chart([4, 4, 5, 5, 6, 6, 7])
                ->color('info')
                ->extraAttributes([
                    'class' => 'shadow-lg rounded-xl transition-all duration-300 hover:scale-105'
                ]),
                
            Stat::make('Clientes', Cliente::count())
                ->description('Total registrados')
                ->descriptionIcon('heroicon-m-users')
                ->chart([2, 3, 4, 5, 6, 7, 8])
                ->color('primary')
                ->extraAttributes([
                    'class' => 'shadow-lg rounded-xl transition-all duration-300 hover:scale-105'
                ]),
        ];
    }
    
    protected function getColumns(): int
    {
        return 4;
    }
}