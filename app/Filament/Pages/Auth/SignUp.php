<?php

namespace App\Filament\Pages\Auth;

use App\Models\MasterKecamatan;
use App\Models\MasterKelurahan;
use App\Models\ModelHasRole;
use App\Models\Role;
use App\Models\UserProfile;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Events\Auth\Registered;
use Filament\Facades\Filament;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register;

class SignUp extends Register
{

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Informasi Akun')
          ->description('Masukan detail informasi akun')
          ->schema([
            $this->getNameFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent()
          ])->columns(1),
        Section::make('Informasi Pribadi')
          ->description('Masukan detail informasi pribadi')
          ->schema([
            TextInput::make('no_kk')
              ->label('No KK')
              ->required()
              ->minLength(16)
              ->maxLength(255),
            TextInput::make('alamat')
              ->label('Alamat')
              ->required()
              ->maxLength(255),
            TextInput::make('rt')
              ->label('RT')
              ->required()
              ->maxLength(255),
            TextInput::make('rw')
              ->label('RW')
              ->required()
              ->maxLength(255),
            Select::make('status_hunian')
              ->label('Status Hunian')
              ->options([
                'Milik Pribadi' => 'Milik Pribadi',
                'Sewa/Kontrak' => 'Sewa/Kontrak'
              ])
              ->required(),
            Select::make('master_kecamatan_id')
              ->label('Kecamatan')
              ->options(MasterKecamatan::pluck('nama', 'id'))
              ->searchable()
              ->required(),
            Select::make('master_kelurahan_id')
              ->label('Kelurahan')
              ->options(MasterKelurahan::pluck('nama', 'id'))
              ->searchable()
              ->required(),
          ])->columns(1),
      ]);
  }

  public function register(): ?RegistrationResponse
  {
    try {
      $this->rateLimit(2);
    } catch (TooManyRequestsException $exception) {
      Notification::make()
        ->title(__('filament-panels::pages/auth/register.notifications.throttled.title', [
          'seconds' => $exception->secondsUntilAvailable,
          'minutes' => ceil($exception->secondsUntilAvailable / 60),
        ]))
        ->body(array_key_exists('body', __('filament-panels::pages/auth/register.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/register.notifications.throttled.body', [
          'seconds' => $exception->secondsUntilAvailable,
          'minutes' => ceil($exception->secondsUntilAvailable / 60),
        ]) : null)
        ->danger()
        ->send();

      return null;
    }

    $data = $this->form->getState();

    $newUser = $this->getUserModel()::create($data);

    $role = Role::where('name', 'penghuni')->first();

    ModelHasRole::create([
      'role_id' => $role['id'],
      'model_type' => 'App\Models\User',
      'model_id' => $newUser['id']
    ]);

    $data['user_id'] = $newUser->id;

    UserProfile::create($data);

    event(new Registered($newUser));

    Filament::auth()->login($newUser);

    session()->regenerate();

    return app(RegistrationResponse::class);
  }
}