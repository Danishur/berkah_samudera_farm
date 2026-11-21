<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Testimoni pembeli')
                ->description('Isi hanya dengan testimoni asli dari pembeli.')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama pembeli')
                        ->required()
                        ->maxLength(100),
                    TextInput::make('city')
                        ->label('Kota')
                        ->placeholder('Contoh: Surabaya')
                        ->maxLength(100),
                    Textarea::make('message')
                        ->label('Isi testimoni')
                        ->rows(4)
                        ->required()
                        ->maxLength(600)
                        ->columnSpanFull(),
                    FileUpload::make('photo')
                        ->label('Foto pembeli (boleh kosong)')
                        ->image()
                        ->disk('public')
                        ->directory('testimonials')
                        ->visibility('public')
                        ->maxSize(2048),
                    Toggle::make('is_active')
                        ->label('Tampilkan di web')
                        ->default(true),
                ])
                ->columns(2)
                ->columnSpanFull(),
        ]);
    }
}
