<?php

namespace App\Filament\Widgets;

use App\Models\PencatatanJentik;
use App\Models\PencatatanKasusDbd;
use App\Models\PencatatanLokasiJentik;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $lokasiJentik = PencatatanLokasiJentik::select('status_jentik', DB::raw('COUNT(*) as count'))
            ->groupBy('status_jentik')
            ->get();

        $angkaBebasJentik = $lokasiJentik->where('status_jentik', 'Tidak/Negatif')->first()->count ?? 0;

        $angkaJentik = $lokasiJentik->where('status_jentik', 'Ada/Positif')->first()->count ?? 0;

        return [
            Stat::make(
                label: 'Total Laporan Jentik',
                value: PencatatanJentik::count()
            ),
            Stat::make(
                label: 'Total Kasus DBD',
                value: PencatatanKasusDbd::count()
            ),
            Stat::make(
                label: 'Total Penghuni',
                value: User::count()
            ),
            Stat::make(
                label: 'Total Fasilitas Umum',
                value: PencatatanJentik::select(DB::raw('COUNT(DISTINCT fasilitas_umum) as count'))
                    ->whereNotNull('fasilitas_umum')
                    ->count()
            ),
            Stat::make(
                label: 'Angka Jentik',
                value: $angkaJentik
            )
                ->description('Persentase: 30%'),
            Stat::make(
                label: 'Angka Bebas Jentik',
                value: $angkaBebasJentik
            )
                ->description('Persentase: 30%'),
        ];
    }
}
