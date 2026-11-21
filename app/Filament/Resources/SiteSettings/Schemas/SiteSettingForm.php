<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Banner beranda')
                ->description('Tulisan besar di bagian paling atas web.')
                ->schema([
                    TextInput::make('hero_title')
                        ->label('Judul utama')
                        ->required()
                        ->maxLength(160)
                        ->columnSpanFull(),
                    Textarea::make('hero_lead')
                        ->label('Kalimat pembuka')
                        ->rows(4)
                        ->maxLength(500)
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),

            Section::make('Kontak dan lokasi')
                ->schema([
                    TextInput::make('wa_number')
                        ->label('Nomor WhatsApp')
                        ->helperText('Contoh: 0852-3196-5000. Semua tombol WhatsApp di web ikut berubah.')
                        ->required()
                        ->maxLength(25),
                    TextInput::make('maps_url')
                        ->label('Link Google Maps')
                        ->helperText('Untuk tombol "Buka di Google Maps". Peta kecil di halaman tidak ikut berubah.')
                        ->url()
                        ->maxLength(500),
                    Textarea::make('address')
                        ->label('Alamat kandang')
                        ->rows(3)
                        ->columnSpanFull(),
                    TextInput::make('instagram_url')
                        ->label('Link Instagram')
                        ->helperText('Kosongkan kalau tidak ada.')
                        ->url()
                        ->maxLength(255),
                    TextInput::make('tiktok_url')
                        ->label('Link TikTok')
                        ->url()
                        ->maxLength(255),
                    TextInput::make('facebook_url')
                        ->label('Link Facebook')
                        ->url()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->columnSpanFull(),

            Section::make('Tentang kami')
                ->schema([
                    Textarea::make('about_1')->label('Paragraf pertama')->rows(4)->columnSpanFull(),
                    Textarea::make('about_2')->label('Paragraf kedua')->rows(4)->columnSpanFull(),
                ])
                ->columnSpanFull(),

            Section::make('Info pengiriman')
                ->description('Tampil di beranda dan halaman Kontak. Tekan Enter untuk baris baru.')
                ->schema([
                    Textarea::make('shipping_info')->label('Isi info pengiriman')->rows(6)->columnSpanFull(),
                ])
                ->columnSpanFull(),
        ]);
    }
}
