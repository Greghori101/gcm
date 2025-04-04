<?php

namespace App\Filament\Admin\Resources;

use App\Enums\BloodTypes;
use App\Enums\Genders;
use App\Filament\Admin\Resources\PatientResource\Pages;
use App\Filament\Admin\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'hugeicons-patient';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()->columns(2)->schema([
                    Forms\Components\TextInput::make('firstname')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('lastname')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(1),
                    Forms\Components\DatePicker::make('birthdate')
                        ->required()
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('phone_number')
                        ->tel()
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(1),
                    Forms\Components\Select::make('blood_type')
                        ->options(BloodTypes::toArray())
                        ->required()
                        ->columnSpan(1),
                    Forms\Components\Select::make('gender')
                        ->options(Genders::toArray())
                        ->required()
                        ->columnSpan(1),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'view' => Pages\ViewPatient::route('/{record}'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
