<?php

namespace Database\Seeders;

use App\Models\Goat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class GoatSeeder extends Seeder
{
    public function run(): void
    {
        // Salin foto contoh dari public/foto ke storage, supaya bisa diedit lewat dashboard.
        foreach (['g1', 'g2', 'g3', 'g4', 'g5'] as $g) {
            $src = public_path("foto/{$g}.jpg");
            if (file_exists($src)) {
                Storage::disk('public')->put("goats/{$g}.jpg", file_get_contents($src));
            }
        }

        // DATA CONTOH. Nanti diganti data asli lewat dashboard admin.
        // [kode, nama, jenis, kelamin, umur(bulan), berat(kg), harga, status, foto, deskripsi]
        $data = [
            ['BSF-001','Pejantan Super','fullblood','Jantan',18,62,8500000,'tersedia','goats/g1.jpg','Badan padat, kaki kokoh, sehat dan aktif. Cocok untuk pejantan.'],
            ['BSF-002','Indukan Pilihan','fullblood','Betina',14,48,6200000,'tersedia','goats/g2.jpg','Betina sehat dengan postur bagus, cocok untuk indukan.'],
            ['BSF-003','Pejantan Besar','fullblood','Jantan',24,75,11000000,'tersedia','goats/g4.jpg','Ukuran besar dengan bobot di atas rata-rata, kualitas pilihan.'],
            ['BSF-004','Jantan Kurban','f1','Jantan',12,45,5400000,'dipesan','goats/g3.jpg','Ukuran ideal untuk kurban, gemuk dan sehat.'],
            ['BSF-005','Betina Muda','f1','Betina',10,38,4800000,'tersedia','goats/g5.jpg','Betina muda dengan pertumbuhan baik.'],
            ['BSF-006','Jantan Kurban','f2','Jantan',11,40,4600000,'tersedia','goats/g1.jpg','Pertumbuhan cepat, cocok untuk kurban dan potong.'],
            ['BSF-007','Betina Indukan','f2','Betina',12,36,4200000,'terjual','goats/g2.jpg','Betina sehat, siap kawin.'],
            ['BSF-008','Jantan Potong','f3','Jantan',10,35,3800000,'tersedia','goats/g3.jpg','Bobot bagus untuk usaha potong dan aqiqah.'],
            ['BSF-009','Jantan Potong','f4','Jantan',9,32,3400000,'tersedia','goats/g4.jpg','Harga terjangkau, pertumbuhan stabil.'],
            ['BSF-010','Betina Muda','f5','Betina',9,30,3000000,'tersedia','goats/g5.jpg','Pilihan hemat untuk pemula beternak.'],
        ];

        foreach ($data as [$code,$name,$breed,$sex,$age,$kg,$price,$status,$photo,$desc]) {
            Goat::updateOrCreate(['code' => $code], [
                'name' => $name, 'breed' => $breed, 'sex' => $sex, 'age_months' => $age,
                'weight_kg' => $kg, 'price' => $price, 'status' => $status,
                'photo' => $photo, 'description' => $desc,
            ]);
        }
    }
}
