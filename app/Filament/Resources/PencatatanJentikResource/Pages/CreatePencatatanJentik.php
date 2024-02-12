<?php

namespace App\Filament\Resources\PencatatanJentikResource\Pages;

use App\Filament\Resources\PencatatanJentikResource;
use App\Models\PencatatanLokasiJentik;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePencatatanJentik extends CreateRecord
{
    protected static string $resource = PencatatanJentikResource::class;

    protected function mutateFormDataBeforeCreate($data): array
    {
        $data['user_id'] = auth()->user()->id;
        $data['master_kelurahan_id'] = auth()->user()->profile->master_kelurahan_id;
        $data['master_kecamatan_id'] = auth()->user()->profile->master_kecamatan_id;
        $data['rw'] = auth()->user()->profile->rw;

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {

        $newRecord = static::getModel()::create($data);

        $data['lokasi_jentik'] = implode(', ', $data['lokasi_jentik']);

        $data['pencatatan_jentik_id'] = $newRecord['id'];

        PencatatanLokasiJentik::create($data);

        return $newRecord;

    }
}
