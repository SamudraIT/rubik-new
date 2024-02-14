<?php

namespace App\Filament\Pages;

use App\Models\ModelHasRole;
use App\Models\PencatatanJentik;
use App\Models\PencatatanKasusDbd;
use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class TabelBerjenjang extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static string $view = 'filament.pages.tabel-berjenjang';

    public function getDataJentik()
    {
        $find_role = ModelHasRole::where('model_id', auth()->id())->first();
        $user_role = $find_role->role;

        if ($user_role['name'] == 'super_admin' || $user_role['name'] == 'dinas') {
            return PencatatanJentik::with(['kecamatan', 'kelurahan'])
                ->groupBy(['master_kelurahan_id', 'master_kecamatan_id', 'rw'])
                ->selectRaw('count(*) as count, master_kelurahan_id, master_kecamatan_id, rw')
                ->get();
        } else {
            return PencatatanJentik::where('rw', auth()->user()->profile->rw)->where('master_kelurahan_id', auth()->user()->profile->master_kelurahan_id)->with(['kecamatan', 'kelurahan'])
                ->groupBy(['master_kelurahan_id', 'master_kecamatan_id', 'rw'])
                ->selectRaw('count(*) as count, master_kelurahan_id, master_kecamatan_id, rw')
                ->get();
        }


    }

    public function getDataDbd()
    {
        $find_role = ModelHasRole::where('model_id', auth()->id())->first();
        $user_role = $find_role->role;

        if ($user_role['name'] == 'super_admin' || $user_role['name'] == 'dinas') {
            return PencatatanKasusDbd::with(['kecamatan', 'kelurahan'])
                ->groupBy(['master_kelurahan_id', 'master_kecamatan_id', 'rw'])
                ->selectRaw('count(*) as count, master_kelurahan_id, master_kecamatan_id, rw')
                ->get();
        } else {
            return PencatatanKasusDbd::where('rw', auth()->user()->profile->rw)->where('master_kelurahan_id', auth()->user()->profile->master_kelurahan_id)->with(['kecamatan', 'kelurahan'])
                ->groupBy(['master_kelurahan_id', 'master_kecamatan_id', 'rw'])
                ->selectRaw('count(*) as count, master_kelurahan_id, master_kecamatan_id, rw')
                ->get();
        }
    }
}
