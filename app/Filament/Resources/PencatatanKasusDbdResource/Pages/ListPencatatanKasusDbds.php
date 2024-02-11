<?php

namespace App\Filament\Resources\PencatatanKasusDbdResource\Pages;

use App\Filament\Resources\PencatatanKasusDbdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPencatatanKasusDbds extends ListRecords
{
    protected static string $resource = PencatatanKasusDbdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
