<?php

namespace App\Filament\Resources\Goats;

use App\Filament\Resources\Goats\Pages\CreateGoat;
use App\Filament\Resources\Goats\Pages\EditGoat;
use App\Filament\Resources\Goats\Pages\ListGoats;
use App\Filament\Resources\Goats\Schemas\GoatForm;
use App\Filament\Resources\Goats\Tables\GoatsTable;
use App\Models\Goat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class GoatResource extends Resource
{
    protected static ?string $model = Goat::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $modelLabel = 'Kambing';

    protected static ?string $pluralModelLabel = 'Kambing';

    protected static ?string $navigationLabel = 'Kambing';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return GoatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GoatsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListGoats::route('/'),
            'create' => CreateGoat::route('/create'),
            'edit'   => EditGoat::route('/{record}/edit'),
        ];
    }
}
