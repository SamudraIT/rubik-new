<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PencatatanJentikResource\Pages;
use App\Filament\Resources\PencatatanJentikResource\RelationManagers;
use App\Models\MasterKecamatan;
use App\Models\MasterKelurahan;
use App\Models\ModelHasRole;
use App\Models\PencatatanJentik;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PencatatanJentikResource extends Resource
{
    protected static ?string $model = PencatatanJentik::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Pencatatan Jentik';

    protected static ?string $navigationGroup = 'Catatan';

    protected static ?string $modelLabel = 'Pencatatan Jentik';

    public static function getEloquentQuery(): Builder
    {
        $find_role = ModelHasRole::where('model_id', auth()->id())->first();
        $user_role = $find_role->role;

        if ($user_role['name'] == 'penghuni') {
            return parent::getEloquentQuery()->where('user_id', auth()->id());
        } else if ($user_role['name'] == 'supervisor') {
            return parent::getEloquentQuery()->where('master_kecamatan_id', auth()->user()->profile->master_kecamatan_id);
        }

        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pelapor')
                    ->description('Masukan detail informasi pelapor')
                    ->schema([
                        TextInput::make('nama_pelapor')
                            ->label('Nama Pelapor')
                            ->required(),
                        TextInput::make('kode_pelapor')
                            ->label('Kode Pelapor')
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
                            ->label('Lokasi')
                            ->reactive()
                            ->options([
                                'Rumah Warga' => 'Rumah Warga',
                                'Tempat dan Fasilitas Umum' => 'Tempat dan Fasilitas Umum'
                            ])
                            ->requiredWith('fasilitas_umum'),
                        TextInput::make('fasilitas_umum')
                            ->label('Fasilitas Umum')
                            ->requiredWith('lokasi')
                            ->hidden(fn(Get $get) => $get('lokasi') != 'Tempat dan Fasilitas Umum'),
                        DatePicker::make('tanggal_pelaporan')
                            ->label('Tanggal Pelaporan')
                            ->required(),
                        FileUpload::make('gambar')
                            ->label('Gambar')
                            ->acceptedFileTypes(['image/*'])
                            ->maxSize(3027)
                            ->directory('gambar-jentik')
                            ->storeFileNamesIn('original_filename')
                            ->required(),
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
                            ->searchable()
                            ->required(),
                        Select::make('status_jentik')
                            ->label('Status Jentik')
                            ->options([
                                'Ada/Positif' => 'Ada/Positif',
                                'Tidak/Negatif' => 'Tidak/Negatif'
                            ])
                            ->required()
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        $find_role = ModelHasRole::where('model_id', auth()->id())->first();
        $user_role = $find_role->role;

        $filters = [];

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
                TextColumn::make('nama_pelapor')
                    ->label('Nama Pelapor'),
                TextColumn::make('kode_pelapor')
                    ->label('Kode Pelapor'),
                TextColumn::make('kepemilikan_ovitrap')
                    ->label('Kepemilikan Ovitrap'),
                TextColumn::make('lokasi')
                    ->label('Lokasi'),
                TextColumn::make('keberadaanJentik.lokasi_jentik')
                    ->label('Lokasi Jentik'),
                TextColumn::make('keberadaanJentik.status_jentik')
                    ->label('Status Jentik'),
                TextColumn::make('tanggal_pelaporan')
                    ->label('Tanggal Pelaporan')
                    ->date(),
            ])
            ->filters($filters)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListPencatatanJentiks::route('/'),
            'create' => Pages\CreatePencatatanJentik::route('/create'),
            'edit' => Pages\EditPencatatanJentik::route('/{record}/edit'),
        ];
    }
}
