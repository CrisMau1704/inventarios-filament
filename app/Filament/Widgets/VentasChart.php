<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Venta;
use Carbon\Carbon;

class VentasChart extends ChartWidget
{
    // 👈 CORREGIDO: sin static
    protected static ?int $sort = 2;
    
    protected function getData(): array
    {
        $ventasPorMes = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $total = Venta::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', $i)
                ->sum('total');
            $ventasPorMes[] = $total;
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Ventas (Bs.)',
                    'data' => $ventasPorMes,
                    'backgroundColor' => '#10b981',
                    'borderColor' => '#059669',
                    'borderWidth' => 2,
                    'pointBackgroundColor' => '#10b981',
                    'pointBorderColor' => '#ffffff',
                    'pointRadius' => 4,
                    'fill' => true,
                ],
            ],
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        ];
    }
    
    protected function getType(): string
    {
        return 'line';
    }
}