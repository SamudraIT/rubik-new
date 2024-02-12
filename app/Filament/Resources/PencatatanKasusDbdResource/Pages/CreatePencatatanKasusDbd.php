<?php

namespace App\Filament\Resources\PencatatanKasusDbdResource\Pages;

use App\Filament\Resources\PencatatanKasusDbdResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePencatatanKasusDbd extends CreateRecord
{
    protected static string $resource = PencatatanKasusDbdResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;
        $data['master_kecamatan_id'] = auth()->user()->profile->master_kecamatan_id;
        $data['master_kelurahan_id'] = auth()->user()->profile->master_kelurahan_id;
        $data['rw'] = auth()->user()->profile->rw;
        $data['gejala_penyakit'] = implode(', ', $data['gejala_penyakit']);

        return $data;
    }
}
