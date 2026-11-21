<?php

namespace App\Filament\Resources\GalleryItems\Schemas;

use App\Models\GalleryItem;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GalleryItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Keterangan')
                ->schema([
                    Select::make('category')
                        ->label('Kategori')
                        ->options(GalleryItem::CATEGORIES)
                        ->default('kandang')
                        ->required(),
                    TextInput::make('title')
                        ->label('Judul')
                        ->placeholder('Contoh: Kandang utama')
                        ->maxLength(100),
                    Textarea::make('caption')
                        ->label('Keterangan singkat')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->columnSpanFull(),

            Section::make('Foto atau video')
                ->description('Isi minimal salah satu: foto, video, atau link YouTube.')
                ->schema([
                    FileUpload::make('image')
                        ->label('Foto')
                        ->helperText('Untuk item video, foto ini menjadi gambar sampul (boleh kosong). Maksimal 5 MB.')
                        ->image()
                        ->disk('public')
                        ->directory('gallery')
                        ->visibility('public')
                        ->maxSize(5120),
                    FileUpload::make('video')
                        ->label('Video')
                        ->helperText('Format MP4. Maksimal 50 MB.')
                        ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'video/webm'])
                        ->disk('public')
                        ->directory('gallery/videos')
                        ->visibility('public')
                        ->maxSize(51200),
                    TextInput::make('youtube_url')
                        ->label('Link YouTube')
                        ->helperText('Untuk video panjang: unggah ke YouTube, lalu tempel linknya di sini.')
                        ->placeholder('https://www.youtube.com/watch?v=...')
                        ->url()
                        ->maxLength(255),
                ])
                ->columnSpanFull(),
        ]);
    }
}
