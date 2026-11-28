<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PageView extends Model
{
    public $timestamps = false;

    protected $fillable = ['visited_on', 'path', 'ip_hash', 'device', 'referrer', 'country_code', 'country', 'region', 'city', 'created_at'];

    protected $casts = [
        'visited_on' => 'date',
        'created_at' => 'datetime',
    ];

    /** Pengunjung unik per hari, lalu dijumlahkan untuk rentang yang dipilih. */
    public static function visitorsBetween(CarbonInterface $from, CarbonInterface $to): int
    {
        return (int) static::query()
            ->whereBetween('visited_on', [$from->toDateString(), $to->toDateString()])
            ->selectRaw('COUNT(DISTINCT visited_on, ip_hash) as total')
            ->value('total');
    }

    public static function viewsBetween(CarbonInterface $from, CarbonInterface $to): int
    {
        return static::query()
            ->whereBetween('visited_on', [$from->toDateString(), $to->toDateString()])
            ->count();
    }

    public static function allTimeVisitors(): int
    {
        return (int) static::query()
            ->selectRaw('COUNT(DISTINCT visited_on, ip_hash) as total')
            ->value('total');
    }

    /** @return array<int, array{label:string, visitors:int, views:int}> */
    public static function dailyStats(int $days): array
    {
        $from = today()->subDays($days - 1);

        $rows = static::query()
            ->whereBetween('visited_on', [$from->toDateString(), today()->toDateString()])
            ->selectRaw('visited_on, COUNT(DISTINCT ip_hash) as visitors, COUNT(*) as views')
            ->groupBy('visited_on')
            ->get()
            ->keyBy(fn ($row) => $row->visited_on->toDateString());

        $out = [];
        for ($i = 0; $i < $days; $i++) {
            $day = $from->copy()->addDays($i);
            $row = $rows->get($day->toDateString());

            $out[] = [
                'label'    => $day->translatedFormat('d M'),
                'visitors' => (int) ($row->visitors ?? 0),
                'views'    => (int) ($row->views ?? 0),
            ];
        }

        return $out;
    }

    public static function dailyVisitors(int $days): array
    {
        return array_column(static::dailyStats($days), 'visitors');
    }

    public static function topPaths(int $days, int $limit = 6, ?string $like = null): Collection
    {
        return static::query()
            ->where('visited_on', '>=', today()->subDays($days - 1)->toDateString())
            ->when($like, fn ($q) => $q->where('path', 'like', $like))
            ->selectRaw('path, COUNT(*) as total')
            ->groupBy('path')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();
    }

    /** Sumber kunjungan pertama (tanpa perpindahan antarhalaman di web sendiri). */
    public static function sourceCounts(int $days): Collection
    {
        return static::query()
            ->where('visited_on', '>=', today()->subDays($days - 1)->toDateString())
            ->where(fn ($q) => $q->whereNull('referrer')->orWhere('referrer', '!=', 'internal'))
            ->selectRaw('referrer, COUNT(*) as total')
            ->groupBy('referrer')
            ->get();
    }

    public static function deviceCounts(int $days): Collection
    {
        return static::query()
            ->where('visited_on', '>=', today()->subDays($days - 1)->toDateString())
            ->selectRaw('device, COUNT(*) as total')
            ->groupBy('device')
            ->get();
    }

    /** Jumlah kunjungan per kolom lokasi (city, region, atau country_code). */
    public static function locationCounts(string $column, int $days, int $limit = 10, ?string $onlyCountry = null): Collection
    {
        abort_unless(in_array($column, ['city', 'region', 'country_code'], true), 500);

        return static::query()
            ->where('visited_on', '>=', today()->subDays($days - 1)->toDateString())
            ->whereNotNull($column)
            ->when($onlyCountry, fn ($q) => $q->where('country_code', $onlyCountry))
            ->selectRaw($column . ' as label, MAX(country) as country_name, COUNT(DISTINCT visited_on, ip_hash) as total')
            ->groupBy($column)
            ->orderByDesc('total')
            ->limit($limit)
            ->get();
    }

    /** @return array{known:int, abroad:int, unknown:int} */
    public static function locationSummary(int $days): array
    {
        $base = fn () => static::query()->where('visited_on', '>=', today()->subDays($days - 1)->toDateString());

        $count = fn ($q) => (int) $q->selectRaw('COUNT(DISTINCT visited_on, ip_hash) as total')->value('total');

        return [
            'known'   => $count($base()->whereNotNull('country_code')),
            'abroad'  => $count($base()->whereNotNull('country_code')->where('country_code', '!=', 'ID')),
            'unknown' => $count($base()->whereNull('country_code')),
        ];
    }
}
