<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use App\Services\GeoLookup;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

class VisitorLocations extends Widget
{
    protected static ?int $sort = 4;

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }

    public function render(): View
    {
        $days    = 30;
        $summary = PageView::locationSummary($days);
        $known   = max(1, $summary['known']);

        return view('filament.widgets.visitor-locations', [
            'days'      => $days,
            'ready'     => GeoLookup::available(),
            'cities'    => PageView::locationCounts('city', $days, 10, 'ID'),
            'regions'   => PageView::locationCounts('region', $days, 6, 'ID'),
            'countries' => PageView::locationCounts('country_code', $days, 8),
            'abroad'    => $summary['abroad'],
            'abroadPct' => $summary['known'] > 0 ? round($summary['abroad'] / $known * 100) : 0,
            'unknown'   => $summary['unknown'],
        ]);
    }
}
