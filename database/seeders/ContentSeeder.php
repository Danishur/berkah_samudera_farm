<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // TEKS AWAL. Cocokkan dengan aturan peternakan, lalu ubah lewat menu FAQ di dashboard.
        $data = [
            ['Bagaimana cara memesan?', 'Pilih kambing di halaman Kambing, klik tombol Pesan lewat WhatsApp, lalu kami layani langsung lewat chat.'],
            ['Apakah bisa dikirim ke luar kota atau luar pulau?', 'Bisa. Kami mengirim dari Mojokerto ke seluruh Indonesia. Ongkos dan jadwal pengiriman dibicarakan lewat WhatsApp.'],
            ['Bagaimana sistem pembayarannya?', 'Metode dan ketentuan pembayaran dijelaskan langsung saat Anda menghubungi kami lewat WhatsApp.'],
            ['Apakah foto dan video sesuai kondisi kambing?', 'Foto dan video di web ini diambil dari kandang kami sendiri. Anda juga bisa meminta foto atau video terbaru lewat WhatsApp.'],
            ['Apakah ada dokumen untuk pengiriman antar provinsi?', 'Pengiriman antar provinsi biasanya memerlukan dokumen kesehatan hewan. Tanyakan lewat WhatsApp untuk detailnya.'],
            ['Bagaimana kalau saya ingin melihat kambing langsung?', 'Hubungi kami lewat WhatsApp untuk menanyakan jadwal kunjungan ke kandang di Kemlagi, Mojokerto.'],
        ];

        foreach ($data as $i => [$tanya, $jawab]) {
            Faq::updateOrCreate(['question' => $tanya], ['answer' => $jawab, 'sort_order' => $i + 1, 'is_active' => true]);
        }
    }
}
