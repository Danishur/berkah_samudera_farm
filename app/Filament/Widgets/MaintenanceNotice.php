<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

class MaintenanceNotice extends Widget
{
    protected static ?int $sort = -10;

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }

    public function render(): View
    {
        return view('filament.widgets.maintenance-notice', [
            'closed' => (bool) config('site.maintenance', true),
            'url'    => SiteSettingResource::getUrl('index'),
        ]);
    }
}
