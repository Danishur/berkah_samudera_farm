<?php

namespace App\Filament\Resources\Goats\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GoatsTable
{
    public static function configure(Table $table): Table
    {
        $status = [
            'tersedia' => 'Tersedia',
            'dipesan'  => 'Dipesan',
            'terjual'  => 'Terjual',
        ];

        return $table
            ->columns([
                ImageColumn::make('photo_url')
                    ->label('Foto')
                    ->square(),
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->description(fn ($record) => $record->breed_label)
                    ->searchable(),
                TextColumn::make('weight_kg')
                    ->label('Berat')
                    ->suffix(' kg')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format((int) $state, 0, ',', '.'))
                    ->sortable(),
                SelectColumn::make('status')
                    ->label('Status')
                    ->options($status)
                    ->selectablePlaceholder(false),
            ])
            ->filters([
                SelectFilter::make('breed')
                    ->label('Jenis')
                    ->options(config('site.breeds')),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options($status),
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
