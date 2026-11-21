<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $disk = Storage::disk('public');

        $salin = function (string $dari, string $ke) use ($disk) {
            if (file_exists($dari)) {
                $disk->put($ke, file_get_contents($dari));
            }
        };

        foreach (['g1', 'g2', 'g3', 'g4', 'g5'] as $g) {
            $salin(public_path("foto/{$g}.jpg"), "gallery/{$g}.jpg");
        }
        $salin(database_path('seeders/sample/video1.mp4'), 'gallery/videos/video1.mp4');
        $salin(database_path('seeders/sample/video2.mp4'), 'gallery/videos/video2.mp4');

        // DATA CONTOH. Ganti dengan foto dan video asli lewat dashboard.
        $data = [
            ['kandang',    'Area kandang',           'Tempat kambing dirawat setiap hari.',       'gallery/g3.jpg', null],
            ['perawatan',  'Perawatan harian',       'Pemberian pakan dan pengecekan kondisi.',   'gallery/g2.jpg', null],
            ['kelahiran',  'Anak kambing baru lahir', 'Dokumentasi kelahiran di peternakan kami.', 'gallery/g5.jpg', null],
            ['video',      'Video kambing pejantan', 'Kondisi kambing pejantan di kandang.',      'gallery/g1.jpg', 'gallery/videos/video1.mp4'],
            ['video',      'Video kambing indukan',  'Kondisi kambing indukan di kandang.',       'gallery/g4.jpg', 'gallery/videos/video2.mp4'],
            ['pengiriman', 'Persiapan pengiriman',   'Kambing disiapkan sebelum dikirim.',        'gallery/g4.jpg', null],
        ];

        foreach ($data as [$kategori, $judul, $ket, $foto, $video]) {
            GalleryItem::updateOrCreate(['title' => $judul], [
                'category' => $kategori,
                'caption'  => $ket,
                'image'    => $foto,
                'video'    => $video,
            ]);
        }
    }
}
