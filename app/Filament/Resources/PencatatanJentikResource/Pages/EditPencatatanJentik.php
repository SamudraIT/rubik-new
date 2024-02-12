<?php

namespace App\Filament\Resources\PencatatanJentikResource\Pages;

use App\Filament\Resources\PencatatanJentikResource;
use App\Models\PencatatanLokasiJentik;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPencatatanJentik extends EditRecord
{
    protected static string $resource = PencatatanJentikResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $lokasiJentikRecord = PencatatanLokasiJentik::where('pencatatan_jentik_id', $data['id'])->first();

        $data['lokasi_jentik'] = explode(', ', $lokasiJentikRecord['lokasi_jentik']);
        $data['status_jentik'] = $lokasiJentikRecord['status_jentik'];

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
