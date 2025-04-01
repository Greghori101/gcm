<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TestRequestResource\Pages;
use App\Filament\Admin\Resources\TestRequestResource\RelationManagers;
use App\Models\TestRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestRequestResource extends Resource
{
    protected static ?string $model = TestRequest::class;

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationIcon = 'fontisto-test-tube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nb')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
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
                Forms\Components\TextInput::make('patient_id')
                    ->maxLength(36)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nb')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('visit_purpose')
                    ->searchable(),
                Tables\Columns\TextColumn::make('conclusion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('patient_id')
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
            'index' => Pages\ListTestRequests::route('/'),
            'create' => Pages\CreateTestRequest::route('/create'),
            'view' => Pages\ViewTestRequest::route('/{record}'),
            'edit' => Pages\EditTestRequest::route('/{record}/edit'),
        ];
    }
}
