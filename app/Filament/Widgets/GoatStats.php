<?php

namespace App\Filament\Widgets;

use App\Models\Goat;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GoatStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Tersedia', Goat::where('status', 'tersedia')->count())->color('success'),
            Stat::make('Dipesan', Goat::where('status', 'dipesan')->count())->color('warning'),
            Stat::make('Terjual', Goat::where('status', 'terjual')->count())->color('danger'),
        ];
    }
}
