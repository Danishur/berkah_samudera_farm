<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Jangan jalankan saat perintah artisan (misalnya migrate), karena tabelnya mungkin belum ada.
        if ($this->app->runningInConsole()) {
            return;
        }

        try {
            $s = Cache::rememberForever('site_settings', fn () => SiteSetting::query()->first()?->toArray() ?? []);
        } catch (\Throwable $e) {
            return;
        }

        if (! $s) {
            return;
        }

        $map = [
            'hero_title'    => 'hero_title',
            'hero_lead'     => 'hero_lead',
            'address'       => 'address',
            'maps_url'      => 'maps',
            'instagram_url' => 'instagram',
            'tiktok_url'    => 'tiktok',
            'facebook_url'  => 'facebook',
            'about_1'       => 'about_1',
            'about_2'       => 'about_2',
            'shipping_info' => 'shipping',
        ];

        $site = config('site');

        foreach ($map as $kolom => $kunci) {
            if (filled($s[$kolom] ?? null)) {
                $site[$kunci] = $s[$kolom];
            }
        }

        $wa = SiteSetting::normalizeWa($s['wa_number'] ?? null);
        if ($wa) {
            $site['wa']         = $wa;
            $site['wa_display'] = SiteSetting::displayWa($wa);
            $site['wa_url']     = 'https://wa.me/' . $wa . '?text='
                . rawurlencode('Halo Berkah Samudera Farm, saya ingin bertanya tentang kambing Boer.');
        }

        $site['maintenance']         = (bool) ($s['maintenance_mode'] ?? true);
        $site['maintenance_message'] = $s['maintenance_message'] ?? null;
        $site['maintenance_eta']     = $s['maintenance_eta'] ?? null;

        config(['site' => $site]);
    }
}
