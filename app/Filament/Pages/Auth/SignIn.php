<?php

namespace App\Filament\Pages\Auth;

use App\Models\UserProfile;
use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Login;

class SignIn extends Login
{

    protected static string $view = 'filament.pages.auth.sign-in';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }

    protected function getLoginFormComponent(): Component
    {
        return TextInput::make('no_kk')
            ->label('No KK / Email')
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    public function authenticate(): ?LoginResponse
    {
        try{
            $this->rateLimit(2);
        }catch(TooManyRequestsException $exception){
            Notification::make()
            ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => ceil($exception->secondsUntilAvailable / 60),
            ]))
            ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => ceil($exception->secondsUntilAvailable / 60),
            ]) : null)
            ->danger()
            ->send();

            return null;
        }

        $data = $this->form->getState();

        $find_profile = UserProfile::where('no_kk', $data['no_kk'])->first();

        if (!$find_profile) {
            $email_login = [
                'email' => $data['no_kk'],
                'password' => $data['password']
            ];

            if (!Filament::auth()->attempt($email_login, $data['remember'] ?? false)) {
                $this->throwFailureValidationException();
            }

            $user = Filament::auth()->user();

            if (($user instanceof FilamentUser) &&(!$user->canAccessPanel(Filament::getCurrentPanel())))
            {
                Filament::auth()->logout();

                $this->throwFailureValidationException();
            }

            session()->regenerate();

            return app(LoginResponse::class);
        } else {
            $find_user = User::where('id', $find_profile['user_id'])->first();

            $credentials = [
                'id' => $find_user['id'],
                'password' => $data['password'],
                'remember' => $data['remember']
            ];

            if (!Filament::auth()->attempt($this->getCredentialsFromFormData($credentials))) {
                $this->throwFailureValidationException();
            }

            $user = Filament::auth()->user();

            if (($user instanceof FilamentUser) && (!$user->canAccessPanel(Filament::getCurrentPanel())))
            {
                Filament::auth()->logout();

                $this->throwFailureValidationException();
            }

            session()->regenerate();

            return app(LoginResponse::class);
        }
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'id' => $data['id'],
            'password' => $data['password']
        ];
    }

}
