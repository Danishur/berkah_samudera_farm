<?php

namespace App\Filament\Resources\Goats\Schemas;

use App\Models\Goat;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GoatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Status stok')
                ->description('Ubah ke Dipesan atau Terjual, dan di website otomatis ikut berubah.')
                ->schema([
                    ToggleButtons::make('status')
                        ->label('Status')
                        ->options([
                            'tersedia' => 'Tersedia',
                            'dipesan'  => 'Dipesan',
                            'terjual'  => 'Terjual',
                        ])
                        ->colors([
                            'tersedia' => 'success',
                            'dipesan'  => 'warning',
                            'terjual'  => 'danger',
                        ])
                        ->default('tersedia')
                        ->inline()
                        ->required(),
                ])
                ->columnSpanFull(),

            Section::make('Data kambing')
                ->schema([
                    TextInput::make('code')
                        ->label('Kode')
                        ->default(fn () => Goat::nextCode())
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(20)
                        ->helperText('Terisi otomatis. Tidak perlu diubah.'),
                    TextInput::make('name')
                        ->label('Nama')
                        ->placeholder('Contoh: Pejantan Super')
                        ->required()
                        ->maxLength(100),
                    Select::make('breed')
                        ->label('Jenis')
                        ->options(config('site.breeds'))
                        ->default('fullblood')
                        ->required(),
                    ToggleButtons::make('sex')
                        ->label('Jenis kelamin')
                        ->options(['Jantan' => 'Jantan', 'Betina' => 'Betina'])
                        ->default('Jantan')
                        ->inline()
                        ->required(),
                    TextInput::make('age_months')
                        ->label('Umur')
                        ->numeric()
                        ->minValue(0)
                        ->suffix('bulan')
                        ->required(),
                    TextInput::make('weight_kg')
                        ->label('Berat')
                        ->numeric()
                        ->minValue(0)
                        ->suffix('kg')
                        ->required(),
                    TextInput::make('price')
                        ->label('Harga')
                        ->numeric()
                        ->minValue(0)
                        ->prefix('Rp')
                        ->helperText('Tulis angka saja tanpa titik. Contoh: 5400000')
                        ->required(),
                    Textarea::make('description')
                        ->label('Deskripsi')
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->columnSpanFull(),

            Section::make('Foto dan video')
                ->schema([
                    FileUpload::make('photo')
                        ->label('Foto utama')
                        ->helperText('Foto kambing dari samping. Maksimal 5 MB.')
                        ->image()
                        ->disk('public')
                        ->directory('goats')
                        ->visibility('public')
                        ->maxSize(5120),
                    FileUpload::make('gallery')
                        ->label('Foto tambahan')
                        ->helperText('Depan, belakang, dan sudut lain. Maksimal 6 foto.')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->maxFiles(6)
                        ->disk('public')
                        ->directory('goats/gallery')
                        ->visibility('public')
                        ->maxSize(5120),
                    FileUpload::make('video')
                        ->label('Video')
                        ->helperText('Format MP4. Maksimal 50 MB.')
                        ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'video/webm'])
                        ->disk('public')
                        ->directory('videos')
                        ->visibility('public')
                        ->maxSize(51200),
                ])
                ->columnSpanFull(),
        ]);
    }
}
