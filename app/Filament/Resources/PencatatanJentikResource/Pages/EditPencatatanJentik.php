<?php

namespace App\Filament\Resources\PencatatanJentikResource\Pages;

use App\Filament\Resources\PencatatanJentikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPencatatanJentik extends EditRecord
{
    protected static string $resource = PencatatanJentikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
