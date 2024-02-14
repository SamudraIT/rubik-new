<?php

namespace App\Filament\Resources\PencatatanKasusDbdResource\Pages;

use App\Filament\Resources\PencatatanKasusDbdResource;
use App\Models\ModelHasRole;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListPencatatanKasusDbds extends ListRecords
{
    protected static string $resource = PencatatanKasusDbdResource::class;

    protected function getHeaderActions(): array
    {
        $find_role = ModelHasRole::where('model_id', auth()->id())->first();
        $user_role = $find_role->role;

        if ($user_role['name'] == 'super_admin' || $user_role['name'] == 'supervisor' || $user_role['name'] == 'dinas') {
            return [
                Actions\CreateAction::make(),
                ExportAction::make()
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename(fn($resource) => $resource::getModelLabel() . '_' . date('Y-m-d'))
                            ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                            ->withColumns([
                                Column::make('updated_at')
                            ])
                    ])
            ];
        }

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
