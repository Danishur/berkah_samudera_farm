<?php

namespace App\Filament\Widgets;

use App\Models\Goat;
use App\Models\PageView;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

class VisitorDetails extends Widget
{
    protected static ?int $sort = 3;

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }

    public function render(): View
    {
        $days  = 30;
        $goats = Goat::pluck('name', 'code');

        $pages = PageView::topPaths($days, 6)->map(fn ($row) => [
            'label' => $this->pageLabel($row->path, $goats),
            'total' => $row->total,
        ]);

        $topGoats = PageView::topPaths($days, 5, '/kambing/%')->map(fn ($row) => [
            'label' => $this->pageLabel($row->path, $goats),
            'total' => $row->total,
        ]);

        $sources = PageView::sourceCounts($days)
            ->groupBy(fn ($row) => $this->sourceLabel($row->referrer))
            ->map(fn ($group) => $group->sum('total'))
            ->sortDesc()
            ->take(6);

        $deviceNames = ['mobile' => 'HP', 'desktop' => 'Laptop atau komputer', 'tablet' => 'Tablet'];
        $deviceRows  = PageView::deviceCounts($days);
        $deviceTotal = max(1, $deviceRows->sum('total'));
        $devices     = $deviceRows->sortByDesc('total')->map(fn ($row) => [
            'label'   => $deviceNames[$row->device] ?? 'Lainnya',
            'percent' => round($row->total / $deviceTotal * 100),
        ]);

        return view('filament.widgets.visitor-details', [
            'days'     => $days,
            'pages'    => $pages,
            'topGoats' => $topGoats,
            'sources'  => $sources,
            'devices'  => $devices,
        ]);
    }

    private function pageLabel(string $path, $goats): string
    {
        return match (true) {
            $path === '/'           => 'Beranda',
            $path === '/kambing'    => 'Daftar kambing',
            $path === '/galeri'     => 'Galeri',
            $path === '/panduan'    => 'Panduan jenis kambing',
            $path === '/kontak'     => 'Kontak',
            str_starts_with($path, '/kambing/') => $this->goatLabel(substr($path, 9), $goats),
            default                 => $path,
        };
    }

    private function goatLabel(string $code, $goats): string
    {
        $name = $goats[$code] ?? null;

        return $name ? "{$name} ({$code})" : $code;
    }

    private function sourceLabel(?string $host): string
    {
        if (! $host) {
            return 'Langsung atau dari WhatsApp';
        }

        $h = strtolower($host);

        return match (true) {
            str_contains($h, 'google.')    => 'Google',
            str_contains($h, 'instagram.') => 'Instagram',
            str_contains($h, 'facebook.'), str_contains($h, 'fb.') => 'Facebook',
            str_contains($h, 'tiktok.')    => 'TikTok',
            str_contains($h, 'youtube.'), $h === 'youtu.be' => 'YouTube',
            str_contains($h, 'bing.')      => 'Bing',
            default                        => $h,
        };
    }
}
