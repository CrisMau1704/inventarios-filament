<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Compra;
use Carbon\Carbon;

class ComprasChart extends ChartWidget
{
    // 👈 CORREGIDO: sin static
    protected ?string $heading = 'Compras mensuales';
    
    protected function getData(): array
    {
        $comprasPorMes = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $total = Compra::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', $i)
                ->sum('total');
            $comprasPorMes[] = $total;
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Compras (Bs.)',
                    'data' => $comprasPorMes,
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#d97706',
                    'borderWidth' => 2,
                    'pointBackgroundColor' => '#f59e0b',
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