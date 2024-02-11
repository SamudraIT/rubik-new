<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MasterRumahSakitResource\Pages;
use App\Filament\Resources\MasterRumahSakitResource\RelationManagers;
use App\Models\MasterRumahSakit;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterRumahSakitResource extends Resource
{
    protected static ?string $model = MasterRumahSakit::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationLabel = 'Rumah Sakit';

    protected static ?string $modelLabel = 'Rumah Sakit';

    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Nama Rumah Sakit')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Rumah Sakit')
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
            'index' => Pages\ListMasterRumahSakits::route('/'),
            'create' => Pages\CreateMasterRumahSakit::route('/create'),
            'edit' => Pages\EditMasterRumahSakit::route('/{record}/edit'),
        ];
    }
}
