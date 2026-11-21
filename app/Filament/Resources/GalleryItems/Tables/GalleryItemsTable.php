<?php

namespace App\Filament\Resources\GalleryItems\Tables;

use App\Models\GalleryItem;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GalleryItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumb_url')
                    ->label('Gambar')
                    ->square()
                    ->defaultImageUrl(asset('images/logo.jpg')),
                TextColumn::make('title')
                    ->label('Judul')
                    ->placeholder('(tanpa judul)')
                    ->searchable(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn ($state) => GalleryItem::CATEGORIES[$state] ?? $state),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(GalleryItem::CATEGORIES),
            ])
            ->defaultSort('id', 'desc')
            ->recordActions([
                EditAction::make()->label('Ubah'),
                DeleteAction::make()->label('Hapus'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
