<?php

namespace App\Filament\Resources\PencatatanKasusDbdResource\Pages;

use App\Filament\Resources\PencatatanKasusDbdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPencatatanKasusDbd extends EditRecord
{
    protected static string $resource = PencatatanKasusDbdResource::class;


    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['gejala_penyakit'] = explode(', ', $data['gejala_penyakit']);

        return $data;

    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
