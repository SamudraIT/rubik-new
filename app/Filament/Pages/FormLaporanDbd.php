<?php

namespace App\Filament\Pages;

use App\Models\MasterRumahSakit;
use App\Models\PencatatanKasusDbd;
use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;

class FormLaporanDbd extends Page
{
    use HasPageShield;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.form-laporan-dbd';

    public ?array $data = [];

    protected function beforeBooted()
    {
        $completed_profile = auth()->user()->profile;

        if (!$completed_profile) {
            return redirect('admin/profile');
        }
    }

    public function mount()
    {
        return $this->form->fill();
    }

    public function form(Form $form): Form
    {

        return $form->schema([
            Section::make('Informasi Pasien')
                ->description('Masukan detail informasi pasien')
                ->schema([
                    TextInput::make('nama_pasien')
                        ->label('Nama Pasien')
                        ->required(),
                    TextInput::make('no_telpon')
                        ->label('Nomor Telpon Pendamping Pasien')
                        ->required(),
                    DatePicker::make('tanggal_terkonfirmasi')
                        ->label('Tanggal Terkonfirmasi')
                        ->required(),
                    DatePicker::make('tanggal_sembuh')
                        ->label('Tanggal Berakhir Penyakit')
                        ->required(),
                    Select::make('gejala_penyakit')
                        ->label('Gejala Penyakit')
                        ->options([
                            'Demam Tinggi Sampai 40 Derajat' => 'Demam Tinggi Sampai 40 Derajat',
                            'Sakit Kepala' => 'Sakit Kepala',
                            'Nyeri otot tulang atau sendi' => 'Nyeri otot tulang atau sendi',
                            'Nausea' => 'Nausea',
                            'Muntah' => 'Muntah',
                            'Sakit di belakang mata' => 'Sakit di belakang mata',
                            'Pembengkakan di kelenjar getah bening di leher dan selangkangan' => 'Pembengkakan di kelenjar getah bening di leher dan selangkangan',
                            'Bintik-bintik merah atau bercak pada kulit' => 'Bintik-bintik merah atau bercak pada kulit',
                        ])
                        ->multiple()
                        ->required()
                        ->columnSpanFull()
                ])->columns(2),
            Section::make('Informasi Laporan')
                ->description('Masukan detail informasi laporan')
                ->schema([
                    Select::make('status_pasien')
                        ->label('Status Pasien')
                        ->options([
                            'Sedang dalam Perawatan' => 'Sedang dalam Perawatan',
                            'Sembuh' => 'Sembuh',
                            'Meninggal' => 'Meninggal'
                        ])
                        ->required(),
                    Select::make('status_laporan')
                        ->label('Status Laporan')
                        ->options([
                            'Terdiagnosa Oleh Dokter' => 'Terdiagnosa Oleh Dokter',
                            'Tidak Terdiagnosa Oleh Dokter' => 'Tidak Terdiagnosa Oleh Dokter'
                        ])
                        ->required(),
                    Select::make('master_rumah_sakit_id')
                        ->label('Lokasi Dirawat')
                        ->options(
                            MasterRumahSakit::pluck('nama', 'id')
                        )
                        ->required()
                        ->columnSpanFull()
                ])->columns(2),
        ])->statePath('data');
    }

    public function submit(): void
    {
        try {
            $data = $this->form->getState();

            $data['user_id'] = auth()->user()->id;
            $data['master_kecamatan_id'] = auth()->user()->profile->master_kecamatan_id;
            $data['master_kelurahan_id'] = auth()->user()->profile->master_kelurahan_id;
            $data['rw'] = auth()->user()->profile->rw;
            $data['gejala_penyakit'] = implode(', ', $data['gejala_penyakit']);

            PencatatanKasusDbd::create($data);

        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title('Sukses menambah laporan dbd')
            ->send();

        $this->form->fill();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Submit')
                ->submit('save')
        ];
    }

    public function getTitle(): string
    {
        return 'Form Pencatatan Kasus DBD';
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('catat-jentik')
                ->label('Form Kasus Jentik')
                ->url(FormLaporan::getUrl())
        ];
    }
}
