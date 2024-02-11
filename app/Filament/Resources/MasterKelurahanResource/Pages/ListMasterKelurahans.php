<?php

namespace App\Filament\Resources\MasterKelurahanResource\Pages;

use App\Filament\Resources\MasterKelurahanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasterKelurahans extends ListRecords
{
    protected static string $resource = MasterKelurahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
