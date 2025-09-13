<?php

namespace App\Filament\Admin\Resources\PatientResource\RelationManagers;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CertificatesRelationManager extends RelationManager
{
    protected static string $relationship = 'certificates';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('period')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('signature')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->default(Carbon::today())
                    ->required(),
                Forms\Components\Textarea::make('purpose')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nb')
            ->columns([
                Tables\Columns\TextColumn::make('nb'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->authorize(true),

            ])
            ->actions([
                Tables\Actions\ViewAction::make()->authorize(true),
                Tables\Actions\EditAction::make()->authorize(true),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }
}
