<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use MaxMind\Db\Reader;

class GeoipUpdate extends Command
{
    protected $signature = 'geoip:update';

    protected $description = 'Unduh database lokasi IP (DB-IP City Lite) terbaru, diperbarui tiap bulan';

    public function handle(): int
    {
        if (! class_exists(Reader::class)) {
            $this->error('Paket maxmind-db/reader belum terpasang. Jalankan: composer require maxmind-db/reader');

            return self::FAILURE;
        }

        $dir = storage_path('app/geoip');
        File::ensureDirectoryExists($dir);

        $gz  = $dir . '/unduhan.mmdb.gz';
        $tmp = $dir . '/baru.mmdb';

        for ($i = 0; $i < 4; $i++) {
            $bulan = now()->subMonthsNoOverflow($i)->format('Y-m');
            $url   = "https://download.db-ip.com/free/dbip-city-lite-{$bulan}.mmdb.gz";

            $this->info("Mengunduh {$url}");

            try {
                $res = Http::timeout(900)->withOptions(['sink' => $gz])->get($url);
            } catch (\Throwable $e) {
                $this->warn('Gagal: ' . $e->getMessage());
                @unlink($gz);
                continue;
            }

            if (! $res->successful()) {
                $this->warn('Belum tersedia untuk bulan ' . $bulan . ' (kode ' . $res->status() . ').');
                @unlink($gz);
                continue;
            }

            $in  = gzopen($gz, 'rb');
            $out = fopen($tmp, 'wb');
            while (! gzeof($in)) {
                fwrite($out, gzread($in, 1048576));
            }
            gzclose($in);
            fclose($out);
            @unlink($gz);

            try {
                new Reader($tmp);   // memastikan file valid
            } catch (\Throwable $e) {
                $this->error('File yang diunduh tidak valid: ' . $e->getMessage());
                @unlink($tmp);

                return self::FAILURE;
            }

            rename($tmp, $dir . '/dbip-city-lite.mmdb');
            $this->info("Selesai. Database lokasi bulan {$bulan} terpasang.");

            return self::SUCCESS;
        }

        $this->error('Database tidak berhasil diunduh. Coba lagi nanti.');

        return self::FAILURE;
    }
}
