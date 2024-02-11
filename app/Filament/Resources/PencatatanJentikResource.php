<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PencatatanJentikResource\Pages;
use App\Filament\Resources\PencatatanJentikResource\RelationManagers;
use App\Models\PencatatanJentik;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pelapor')
                    ->description('Masukan detail informasi pelapor')
                    ->schema([
                        TextInput::make('nama_pasien')
                            ->label('Nama Pasien')
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

                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
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
