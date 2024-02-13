<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\ZPencatatanJentikChart;
use App\Filament\Widgets\ZPencatatanKasusDbdChart;
use App\Models\ModelHasRole;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class CustomDashboard extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static string $view = 'filament.pages.custom-dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    protected function beforeBooted() {
        $find_role = ModelHasRole::where('model_id', auth()->id())->first();
        $user_role = $find_role->role;

        if ($user_role['name'] == 'supervisor') {
            $completed_profile = auth()->user()->profile;
            if (!$completed_profile) {
                return redirect('admin/profile');
            }
        } else {
            return;
        }
    }

    public function getTitle(): string {
        return 'Dashboard';
    }

    protected function getHeaderWidgets(): array {
        return [
            StatsOverview::class,
            ZPencatatanJentikChart::class,
            ZPencatatanKasusDbdChart::class,
        ];
    }
}
