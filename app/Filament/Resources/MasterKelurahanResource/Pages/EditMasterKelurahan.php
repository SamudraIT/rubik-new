<?php

namespace App\Filament\Resources\MasterKelurahanResource\Pages;

use App\Filament\Resources\MasterKelurahanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMasterKelurahan extends EditRecord
{
    protected static string $resource = MasterKelurahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
