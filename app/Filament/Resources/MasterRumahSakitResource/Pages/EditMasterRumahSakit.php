<?php

namespace App\Filament\Resources\MasterRumahSakitResource\Pages;

use App\Filament\Resources\MasterRumahSakitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMasterRumahSakit extends EditRecord
{
    protected static string $resource = MasterRumahSakitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
