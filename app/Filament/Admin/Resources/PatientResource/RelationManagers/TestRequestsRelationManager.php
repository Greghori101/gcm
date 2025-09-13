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

class TestRequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'testRequests';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('past_medical_history')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('visit_purpose')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('conclusion')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('requests')
                    ->required()
                    ->columnSpanFull(),
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
