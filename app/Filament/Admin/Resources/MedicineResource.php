<?php

namespace App\Filament\Admin\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\MedicineResource\Pages\ListMedicines;
use App\Filament\Admin\Resources\MedicineResource\Pages\CreateMedicine;
use App\Filament\Admin\Resources\MedicineResource\Pages\ViewMedicine;
use App\Filament\Admin\Resources\MedicineResource\Pages\EditMedicine;
use App\Filament\Admin\Resources\MedicineResource\Pages;
use App\Filament\Admin\Resources\MedicineResource\RelationManagers;
use App\Models\Medicine;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MedicineResource extends Resource
{
    protected static ?string $model = Medicine::class;

    protected static ?int $navigationSort = 8;

    protected static string | \BackedEnum | null $navigationIcon = 'css-pill';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ne')
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('brand')
                    ->required()
                    ->maxLength(255),
                TextInput::make('form')
                    ->required()
                    ->maxLength(255),
                TextInput::make('dosage')
                    ->required()
                    ->maxLength(255),
                TextInput::make('packaging')
                    ->required()
                    ->maxLength(255),
                TextInput::make('list')
                    ->required()
                    ->maxLength(255),
                TextInput::make('p1')
                    ->required()
                    ->maxLength(255),
                TextInput::make('p2')
                    ->required()
                    ->maxLength(255),
                TextInput::make('obs')
                    ->required()
                    ->maxLength(255),
                TextInput::make('laboratory')
                    ->required()
                    ->maxLength(255),
                TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                TextInput::make('period')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ne')
                    ->searchable(),
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('brand')
                    ->searchable(),
                TextColumn::make('form')
                    ->searchable(),
                TextColumn::make('dosage')
                    ->searchable(),
                TextColumn::make('packaging')
                    ->searchable(),
                TextColumn::make('list')
                    ->searchable(),
                TextColumn::make('p1')
                    ->searchable(),
                TextColumn::make('p2')
                    ->searchable(),
                TextColumn::make('obs')
                    ->searchable(),
                TextColumn::make('laboratory')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('period')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListMedicines::route('/'),
            'create' => CreateMedicine::route('/create'),
            'view' => ViewMedicine::route('/{record}'),
            'edit' => EditMedicine::route('/{record}/edit'),
        ];
    }
}
