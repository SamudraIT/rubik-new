<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PencatatanKasusDbdResource\Pages;
use App\Filament\Resources\PencatatanKasusDbdResource\RelationManagers;
use App\Models\MasterKecamatan;
use App\Models\MasterKelurahan;
use App\Models\MasterRumahSakit;
use App\Models\ModelHasRole;
use App\Models\PencatatanKasusDbd;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PencatatanKasusDbdResource extends Resource
{
    protected static ?string $model = PencatatanKasusDbd::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Pencatatan Kasus DBD';

    protected static ?string $navigationGroup = 'Catatan';

    protected static ?string $modelLabel = 'Pencatatan Kasus DBD';

    public static function getEloquentQuery(): Builder
    {
        $find_role = ModelHasRole::where('model_id', auth()->id())->first();
        $user_role = $find_role->role;

        if ($user_role['name'] == 'nakes') {
            return parent::getEloquentQuery()->where('master_rumah_sakit_id', auth()->user()->profile->master_rumah_sakit_id);
        } else if ($user_role['name'] == 'penghuni') {
            return parent::getEloquentQuery()->where('user_id', auth()->id())->where('terkonfirmasi_nakes', true);
        } else if ($user_role['name'] == 'supervisor') {
            return parent::getEloquentQuery()->where('master_kecamatan_id', auth()->user()->profile->master_kecamatan_id);
        }

        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ]);
    }

    public static function table(Table $table): Table
    {
        $find_role = ModelHasRole::where('model_id', auth()->id())->first();
        $user_role = $find_role->role;

        $filters = [];
        $actions = [];

        if ($user_role['name'] == 'penghuni') {
            $actions = [
                Tables\Actions\EditAction::make(),
            ];
        } else {
            $actions = [
                Action::make('confirm')
                    ->visible(function (Model $record) {
                        return $record->terkonfirmasi_nakes ? false : true;
                    })
                    ->label('Confirm')
                    ->action(function (PencatatanKasusDbd $record) {
                        $record->update([
                            'terkonfirmasi_nakes' => true
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Laporan berhasil di konfirmasi')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Kasus')
                    ->color('success')
                    ->modalIcon('heroicon-o-information-circle')
                    ->modalDescription('Anda yakin ingin mengkonfirmasi?')
                    ->modalSubmitActionLabel('Ya, Saya yakin'),
                Action::make('cancel')
                    ->visible(function (Model $record) {
                        return $record->terkonfirmasi_nakes ? true : false;
                    })
                    ->label('Cancel')
                    ->action(function (PencatatanKasusDbd $record) {
                        $record->update([
                            'terkonfirmasi_nakes' => false
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Konfirmasi Laporan berhasil di batalkan')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Kasus')
                    ->color('danger')
                    ->modalIcon('heroicon-o-information-circle')
                    ->modalDescription('Anda yakin ingin membatalkan konfirmasi?')
                    ->modalSubmitActionLabel('Ya, Saya yakin'),
                Tables\Actions\EditAction::make(),
            ];
        }

        if ($user_role['name'] == 'dinas' || $user_role['name'] == 'super_admin') {
            $filters = [
                SelectFilter::make('master_kecamatan_id')
                    ->label('Kecamatan')
                    ->options(MasterKecamatan::pluck('nama', 'id')),
                SelectFilter::make('master_kelurahan_id')
                    ->label('Kelurahan')
                    ->options(MasterKelurahan::pluck('nama', 'id')),
            ];
        } else if ($user_role['name'] == 'supervisor') {
            $filters = [
                SelectFilter::make('master_kelurahan_id')
                    ->label('Kelurahan')
                    ->options(MasterKelurahan::pluck('nama', 'id')),
            ];
        }

        return $table
            ->columns([
                TextColumn::make('nama_pasien')
                    ->label('Nama Pasien')
                    ->sortable(),
                TextColumn::make('status_pasien')
                    ->label('Status Pasien')
                    ->sortable(),
                TextColumn::make('gejala_penyakit')
                    ->label('Gejala Penyakit')
                    ->sortable(),
                TextColumn::make('no_telpon')
                    ->label('Nomor Telpon Pendamping Pasien')
                    ->sortable(),
                TextColumn::make('tanggal_terkonfirmasi')
                    ->label('Tanggal Terkonfirmasi')
                    ->sortable(),
                TextColumn::make('terkonfirmasi_nakes')
                    ->label('Status Laporan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Terkonfirmasi' => 'success',
                        'Tidak Terkonfirmasi' => 'danger'
                    })
                    ->getStateUsing(function ($record) {
                        return $record->terkonfirmasi_nakes ? 'Terkonfirmasi' : 'Tidak Terkonfirmasi';
                    })

            ])
            ->filters($filters)
            ->actions($actions)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPencatatanKasusDbds::route('/'),
            'create' => Pages\CreatePencatatanKasusDbd::route('/create'),
            'edit' => Pages\EditPencatatanKasusDbd::route('/{record}/edit'),
        ];
    }
}
