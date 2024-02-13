<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ZPencatatanJentikChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'pencatatanJentikChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Laporan Pencatatan Jentik';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {

        $data = DB::table('pencatatan_lokasi_jentik')
            ->select(DB::raw('MONTH(created_at) as month, status_jentik, COUNT(*) as count'))
            ->whereNotNull('status_jentik')
            // ->whereBetween('created_at', [
            //     Carbon::parse($this->filterFormData['date_start']),
            //     Carbon::parse($this->filterFormData['date_end']),
            // ])
            ->groupBy('month', 'status_jentik')
            ->get();

        $transformedData = [];

        foreach ($data as $record) {
            $month = $record->month;
            $status = $record->status_jentik;
            $count = $record->count;

            if (!isset($transformedData[$status])) {
                $transformedData[$status] = array_fill(1, 12, 0);
            }

            $transformedData[$status][$month] = $count;
        }

        $finalData = [];

        foreach ($transformedData as $status => $counts) {
            $dataForStatus = [
                'name' => $status,
                'data' => array_values($counts),
            ];

            $finalData[] = $dataForStatus;
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => $finalData,
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => [
                '#ef4444',
                '#10b981',
                '#f59e0b',
            ],
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            DatePicker::make('date_start')
                ->default(now()->subMonth()),
            DatePicker::make('date_end')
                ->default(now()),
        ];
    }
}
