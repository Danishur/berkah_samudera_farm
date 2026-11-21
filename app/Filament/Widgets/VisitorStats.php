<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VisitorStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $fmt = fn (int $n) => number_format($n, 0, ',', '.');

        $hariIni = PageView::visitorsBetween(today(), today());
        $dibuka  = PageView::viewsBetween(today(), today());
        $tujuh   = PageView::visitorsBetween(today()->subDays(6), today());
        $bulan   = PageView::visitorsBetween(today()->subDays(29), today());
        $semua   = PageView::allTimeVisitors();

        return [
            Stat::make('Pengunjung hari ini', $fmt($hariIni))
                ->description($fmt($dibuka) . ' halaman dibuka')
                ->color('success'),
            Stat::make('7 hari terakhir', $fmt($tujuh))
                ->description('pengunjung, dihitung per hari')
                ->chart(PageView::dailyVisitors(7))
                ->color('warning'),
            Stat::make('30 hari terakhir', $fmt($bulan))
                ->description('pengunjung, dihitung per hari')
                ->chart(PageView::dailyVisitors(14))
                ->color('warning'),
            Stat::make('Seluruhnya', $fmt($semua))
                ->description('sejak pencatatan dimulai'),
        ];
    }
}
