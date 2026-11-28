<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'hero_title', 'hero_lead', 'wa_number', 'address', 'maps_url',
        'instagram_url', 'tiktok_url', 'facebook_url',
        'about_1', 'about_2', 'shipping_info',
        'maintenance_mode', 'maintenance_message', 'maintenance_eta',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site_settings'));
        static::deleted(fn () => Cache::forget('site_settings'));
    }

    /** Satu-satunya baris pengaturan. Dibuat otomatis dengan isi bawaan dari config/site.php. */
    public static function current(): self
    {
        return static::query()->first() ?? static::create([
            'hero_title'    => config('site.hero_title'),
            'hero_lead'     => config('site.hero_lead'),
            'wa_number'     => config('site.wa'),
            'address'       => config('site.address'),
            'maps_url'      => config('site.maps'),
            'about_1'       => config('site.about_1'),
            'about_2'       => config('site.about_2'),
            'shipping_info' => config('site.shipping'),
            'maintenance_mode' => (bool) config('site.maintenance', true),
        ]);
    }

    /** 0852-3196-5000, +62 852..., 852... semuanya menjadi 6285231965000 */
    public static function normalizeWa(?string $raw): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $raw);

        if ($digits === '') {
            return null;
        }
        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }
        if (str_starts_with($digits, '8')) {
            return '62' . $digits;
        }

        return $digits;
    }

    public static function displayWa(string $digits): string
    {
        if (str_starts_with($digits, '62') && strlen($digits) >= 11) {
            return '+62 ' . substr($digits, 2, 3) . '-' . substr($digits, 5, 4) . '-' . substr($digits, 9);
        }

        return '+' . $digits;
    }
}
