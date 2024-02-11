<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MasterKelurahanResource\Pages;
use App\Filament\Resources\MasterKelurahanResource\RelationManagers;
use App\Models\MasterKelurahan;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterKelurahanResource extends Resource
{
    protected static ?string $model = MasterKelurahan::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Kelurahan';

    protected static ?string $modelLabel = 'Kelurahan';

    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Nama Kelurahan')
                    ->required(),
                Select::make('master_kecamatan_id')
                    ->label('Nama kecamatan')
                    ->relationship(name: 'kecamatan', titleAttribute: 'nama')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Kelurahan')
                    ->sortable(),
                TextColumn::make('kecamatan.nama')
                    ->label('Kecamatan')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
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
            'index' => Pages\ListMasterKelurahans::route('/'),
            'create' => Pages\CreateMasterKelurahan::route('/create'),
            'edit' => Pages\EditMasterKelurahan::route('/{record}/edit'),
        ];
    }
}
