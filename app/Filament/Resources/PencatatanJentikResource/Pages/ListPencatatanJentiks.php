<?php

namespace App\Filament\Resources\PencatatanJentikResource\Pages;

use App\Filament\Resources\PencatatanJentikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;

class ListPencatatanJentiks extends ListRecords
{
    protected static string $resource = PencatatanJentikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {

        return [
            'Semua' => Tab::make(),
            'Minggu Ini' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('tanggal_pelaporan', '>=', now()->subWeek())),
            'Bulan Ini' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('tanggal_pelaporan', '>=', now()->subMonth())),
            'Tahun Ini' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('tanggal_pelaporan', '>=', now()->subYear())),
        ];
    }
}
