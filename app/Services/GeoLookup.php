<?php

namespace App\Services;

use MaxMind\Db\Reader;

/**
 * Menebak negara, provinsi, dan kota dari alamat IP memakai database lokal (DB-IP City Lite).
 * Alamat IP tidak dikirim ke layanan luar dan tidak disimpan.
 */
class GeoLookup
{
    private static ?Reader $reader = null;

    private const PROVINSI = [
        'East Java' => 'Jawa Timur', 'Central Java' => 'Jawa Tengah', 'West Java' => 'Jawa Barat',
        'Jakarta' => 'DKI Jakarta', 'Special Region of Yogyakarta' => 'DI Yogyakarta', 'Yogyakarta' => 'DI Yogyakarta',
        'North Sumatra' => 'Sumatera Utara', 'West Sumatra' => 'Sumatera Barat', 'South Sumatra' => 'Sumatera Selatan',
        'Riau Islands' => 'Kepulauan Riau', 'Bangka Belitung Islands' => 'Kepulauan Bangka Belitung',
        'East Kalimantan' => 'Kalimantan Timur', 'West Kalimantan' => 'Kalimantan Barat',
        'South Kalimantan' => 'Kalimantan Selatan', 'Central Kalimantan' => 'Kalimantan Tengah',
        'North Kalimantan' => 'Kalimantan Utara', 'South Sulawesi' => 'Sulawesi Selatan',
        'North Sulawesi' => 'Sulawesi Utara', 'Central Sulawesi' => 'Sulawesi Tengah',
        'Southeast Sulawesi' => 'Sulawesi Tenggara', 'West Sulawesi' => 'Sulawesi Barat',
        'West Nusa Tenggara' => 'Nusa Tenggara Barat', 'East Nusa Tenggara' => 'Nusa Tenggara Timur',
        'Aceh' => 'Aceh', 'Bali' => 'Bali', 'Banten' => 'Banten', 'Lampung' => 'Lampung', 'Riau' => 'Riau',
        'Jambi' => 'Jambi', 'Bengkulu' => 'Bengkulu', 'Gorontalo' => 'Gorontalo', 'Maluku' => 'Maluku',
        'North Maluku' => 'Maluku Utara', 'West Papua' => 'Papua Barat', 'Papua' => 'Papua',
    ];

    public static function path(): string
    {
        return storage_path('app/geoip/dbip-city-lite.mmdb');
    }

    public static function available(): bool
    {
        return class_exists(Reader::class) && is_file(self::path());
    }

    /** @return array{country_code:?string,country:?string,region:?string,city:?string}|null */
    public static function locate(?string $ip): ?array
    {
        if (! $ip || ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return null;
        }

        $reader = self::reader();
        if (! $reader) {
            return null;
        }

        $r = $reader->get($ip);
        if (! is_array($r)) {
            return null;
        }

        $code = $r['country']['iso_code'] ?? $r['country_code'] ?? null;
        $city = $r['city']['names']['en'] ?? (is_string($r['city'] ?? null) ? $r['city'] : null);
        $region = $r['subdivisions'][0]['names']['en'] ?? ($r['state1'] ?? null);
        $countryEn = $r['country']['names']['en'] ?? null;

        if (! $code) {
            return null;
        }

        return [
            'country_code' => strtoupper(substr($code, 0, 2)),
            'country'      => self::countryName($code, $countryEn),
            'region'       => $region ? mb_substr(self::PROVINSI[$region] ?? $region, 0, 100) : null,
            'city'         => $city ? mb_substr($city, 0, 100) : null,
        ];
    }

    private static function countryName(string $code, ?string $fallback): ?string
    {
        if (class_exists(\Locale::class)) {
            $name = \Locale::getDisplayRegion('-' . strtoupper($code), 'id');
            if ($name && $name !== strtoupper($code)) {
                return mb_substr($name, 0, 80);
            }
        }

        return $fallback ? mb_substr($fallback, 0, 80) : strtoupper($code);
    }

    private static function reader(): ?Reader
    {
        if (self::$reader) {
            return self::$reader;
        }

        if (! self::available()) {
            return null;
        }

        try {
            return self::$reader = new Reader(self::path());
        } catch (\Throwable $e) {
            return null;
        }
    }
}
