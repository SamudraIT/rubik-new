<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\UserProfile;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $profile = UserProfile::where('user_id', $data['id'])->first();

        if ($profile && $profile['nakes']) {
            $data['nakes'] = $profile['nakes'];
            $data['master_rumah_sakit_id'] = $profile['master_rumah_sakit_id'];
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
