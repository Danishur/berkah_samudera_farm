<?php

namespace App\Filament\Resources\Faqs\Schemas;

use App\Models\Faq;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Pertanyaan umum')
                ->schema([
                    TextInput::make('question')
                        ->label('Pertanyaan')
                        ->required()
                        ->maxLength(200)
                        ->columnSpanFull(),
                    Textarea::make('answer')
                        ->label('Jawaban')
                        ->rows(4)
                        ->required()
                        ->columnSpanFull(),
                    Hidden::make('sort_order')
                        ->default(fn () => (Faq::max('sort_order') ?? 0) + 1),
                    Toggle::make('is_active')
                        ->label('Tampilkan di web')
                        ->default(true),
                ])
                ->columnSpanFull(),
        ]);
    }
}
