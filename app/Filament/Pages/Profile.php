<?php

namespace App\Filament\Pages;

use App\Models\MasterKecamatan;
use App\Models\MasterKelurahan;
use App\Models\ModelHasRole;
use App\Models\UserProfile;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;

class Profile extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.profile';

    public ?array $data = [];

    public function mount(): void
    {
        if (auth()->user()->profile) {
            $user_data = array_merge(auth()->user()->profile->attributesToArray(), [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email
            ]);
            $this->form->fill($user_data);
        } else {
            $this->form->fill(['name' => auth()->user()->name]);
        }
    }

    public function form(Form $form): Form
    {
        $find_role = ModelHasRole::where('model_id', auth()->id())->first();
        $user_role = $find_role->role;
        $schema = [];

        $kecamatanOpts = MasterKecamatan::pluck('nama', 'id');
        $kelurahanOpts = MasterKelurahan::pluck('nama', 'id');

        if ($user_role['name'] == 'supervisor') {
            $schema = [
                Section::make('Informasi Akun')
                    ->description('Informasi akun anda')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->disabled(),
                        TextInput::make('email')
                            ->label('Email')
                            ->disabled()
                    ]),
                Section::make('Informasi Pribadi')
                    ->description('Informasi pribadi anda')
                    ->schema([
                        TextInput::make('rt')
                            ->label('RT')
                            ->required(),
                        TextInput::make('rw')
                            ->label('RW')
                            ->required(),
                        Select::make('master_kelurahan_id')
                            ->label('Kelurahan')
                            ->options($kelurahanOpts)
                            ->required(),
                        Select::make('master_kecamatan_id')
                            ->label('Kecamatan')
                            ->options($kecamatanOpts)
                            ->required(),
                    ])->columns(2),
            ];
        } else {
            $schema = [
                Section::make('Informasi Akun')
                    ->description('Informasi akun anda')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->default(auth()->user()->name)
                            ->disabled()
                    ]),
                Section::make('Informasi Pribadi')
                    ->description('Informasi pribadi anda')
                    ->schema([
                        TextInput::make('no_kk')
                            ->label('No KK')
                            ->minLength(16)
                            ->required(),
                        TextInput::make('alamat')
                            ->label('Alamat')
                            ->required(),
                        TextInput::make('rt')
                            ->label('RT')
                            ->required(),
                        TextInput::make('rw')
                            ->label('RW')
                            ->required(),
                        Select::make('status_hunian')
                            ->label('Status Hunian')
                            ->options([
                                'Milik Pribadi' => 'Milik Pribadi',
                                'Sewa/Kontrak' => 'Sewa/Kontrak'
                            ])
                            ->required(),
                        Select::make('master_kelurahan_id')
                            ->label('Kelurahan')
                            ->options($kelurahanOpts)
                            ->required(),
                        Select::make('master_kecamatan_id')
                            ->label('Kecamatan')
                            ->options($kecamatanOpts)
                            ->required(),
                    ])->columns(2)
            ];
        }


        return $form->schema($schema)->statePath('data');
    }

    public function submit(): void
    {
        try {
            $data = $this->form->getState();
            $data['user_id'] = auth()->user()->id;

            unset($data['nama']);

            $find_profile = UserProfile::where('user_id', $data['user_id'])->first();

            if (!$find_profile) {
                UserProfile::create($data);
            } else {
                UserProfile::where('user_id', $data['user_id'])->update($data);
            }

        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title('Berhasil memperbarui profile')
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Submit')
                ->submit('save')
        ];
    }
}
