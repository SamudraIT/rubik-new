<?php

namespace App\Filament\Resources\PencatatanKasusDbdResource\Pages;

use App\Filament\Resources\PencatatanKasusDbdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPencatatanKasusDbds extends ListRecords
{
    protected static string $resource = PencatatanKasusDbdResource::class;

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
            'Minggu Ini' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('tanggal_terkonfirmasi', '>=', now()->subWeek())),
            'Bulan Ini' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('tanggal_terkonfirmasi', '>=', now()->subMonth())),
            'Tahun Ini' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('tanggal_terkonfirmasi', '>=', now()->subYear())),
        ];
    }
}
