<x-filament-panels::page.simple>
  @if (filament()->hasRegistration())
  <x-slot name="subheading">
    {{ __('filament-panels::pages/auth/login.actions.register.before') }}

    {{ $this->registerAction }}
  </x-slot>
  @endif

  {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.before', scopes: $this->getRenderHookScopes()) }}

  <x-filament-panels::form wire:submit="authenticate">
    {{ $this->form }}

    <div style="display: flex; align-items: center; justify-content: flex-end;">
      <a href="/dashboard/reset-password" style="font-size: .8rem;">Lupa Password?</a>
    </div>

    <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
  </x-filament-panels::form>

  {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.after', scopes: $this->getRenderHookScopes()) }}
</x-filament-panels::page.simple>
