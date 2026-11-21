<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\ChartWidget;

class VisitorChart extends ChartWidget
{
    protected static ?int $sort = 2;

    public function getHeading(): ?string
    {
        return 'Grafik pengunjung';
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }

    protected function getFilters(): ?array
    {
        return [
            '7'  => '7 hari terakhir',
            '30' => '30 hari terakhir',
            '90' => '90 hari terakhir',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $rows = PageView::dailyStats((int) ($this->filter ?? 30));

        return [
            'datasets' => [
                [
                    'label'           => 'Pengunjung',
                    'data'            => array_column($rows, 'visitors'),
                    'borderColor'     => '#e0b04a',
                    'backgroundColor' => 'rgba(224, 176, 74, 0.15)',
                    'fill'            => true,
                    'tension'         => 0.3,
                ],
                [
                    'label'       => 'Halaman dibuka',
                    'data'        => array_column($rows, 'views'),
                    'borderColor' => '#9ca3af',
                    'tension'     => 0.3,
                ],
            ],
            'labels' => array_column($rows, 'label'),
        ];
    }
}
