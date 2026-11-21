<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Resources\Pages\EditRecord;

class EditSiteSetting extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // 0852-3196-5000 atau +62 852... otomatis menjadi 6285231965000
        $data['wa_number'] = SiteSetting::normalizeWa($data['wa_number'] ?? null) ?? ($data['wa_number'] ?? null);

        return $data;
    }
}
