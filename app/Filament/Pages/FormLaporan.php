<?php

namespace App\Filament\Pages;

use App\Models\PencatatanJentik;
use App\Models\PencatatanLokasiJentik;
use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;

class FormLaporan extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.form-laporan';

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
        return $form
            ->schema([
                Section::make('Informasi Pelapor')
                    ->description('Masukan detail informasi pelapor')
                    ->schema([
                        TextInput::make('nama_pelapor')
                            ->label('Nama Pelapor')
                            ->maxLength(255)
                            ->minLength(2)
                            ->required(),
                        TextInput::make('kode_pelapor')
                            ->label('Kode Pelapor')
                            ->maxLength(255)
                            ->minLength(2)
                            ->required(),
                    ])->columns(2),

                Section::make('Informasi Laporan')
                    ->description('Masukan detail informasi laporan')
                    ->schema([
                        Select::make('kepemilikan_ovitrap')
                            ->label('Kepemilikan Ovitrap')
                            ->options([
                                'Dengan Ovitrap' => 'Dengan Ovitrap',
                                'Tanpa Ovitrap' => 'Tanpa Ovitrap'
                            ])
                            ->required(),
                        Select::make('lokasi')
                            ->label('Tempat')
                            ->options([
                                'Rumah Warga' => 'Rumah Warga',
                            ])
                            ->required(),
                        DatePicker::make('tanggal_pelaporan')
                            ->label('Tanggal Pelaporan')
                            ->required(),
                        FileUpload::make('gambar')
                            ->label('Gambar')
                            ->directory('gambar-jentik')
                            ->acceptedFileTypes(['image/*'])
                            ->maxSize(3027)
                            ->storeFileNamesIn('original_filename')
                            ->required()
                    ])->columns(2),

                Section::make('Keberadaan Jentik')
                    ->description('Masukan detail keberadaan jentik')
                    ->schema([
                        Select::make('lokasi_jentik')
                            ->label('Lokasi Jentik')
                            ->options([
                                'Dispenser' => 'Dispenser',
                                'Bak Mandi' => 'Bak Mandi',
                                'Bak Belakang Kulkas' => 'Bak Belakang Kulkas',
                                'Tatakan Pot Luar Ruangan' => 'Tatakan Pot Luar Ruangan',
                                'Tempat Minum Hewan Peliharaan' => 'Tempat Minum Hewan Peliharaan',
                                'Tempat Penampungan Air Hujan/AC' => 'Tempat Penampungan Air Hujan/AC',
                                'Ban Bekas' => 'Ban Bekas',
                                'Kaleng/Botol Bekas' => 'Kaleng/Botol Bekas',
                                'Ovitrap' => 'Ovitrap',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->multiple()
                            ->required(),
                        Select::make('status_jentik')
                            ->label('Status Jentik')
                            ->options([
                                'Ada/Positif' => 'Ada/Positif',
                                'Tidak/Negatif' => 'Tidak/Negatif'
                            ])
                            ->required(),
                    ])
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        try {
            $data = $this->form->getState();

            $data['user_id'] = auth()->user()->id;
            $data['master_kelurahan_id'] = auth()->user()->profile->master_kelurahan_id;
            $data['master_kecamatan_id'] = auth()->user()->profile->master_kecamatan_id;
            $data['rw'] = auth()->user()->profile->rw;
            $data['lokasi_jentik'] = implode(', ', $data['lokasi_jentik']);

            $newRecord = PencatatanJentik::create($data);

            $data['pencatatan_jentik_id'] = $newRecord->id;

            PencatatanLokasiJentik::create($data);

        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title('Sukses menambahkan laporan jentik')
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
        return 'Form Pencatatan Jentik';
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('kasus-dbd')
                ->label('Form Kasus DBD')
                ->url(FormLaporanDbd::getUrl())
        ];
    }
}
