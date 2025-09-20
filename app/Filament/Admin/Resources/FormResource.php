<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FormResource\Pages;
use App\Filament\Admin\Resources\FormResource\RelationManagers;
use App\Models\Form as FormModel;
use App\Models\Medicine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('form')
                    ->options(fn() => Medicine::query()
                        ->select('form')
                        ->distinct()
                        ->pluck('form', 'form')
                        ->toArray())
                    ->columnSpan(1)
                    ->required(),

                Forms\Components\TagsInput::make('notations')
                    ->columnSpan(1)
                    ->required()
                    ->separator(','),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('form')
                    ->label('Form')
                    ->searchable(),
                Tables\Columns\TextColumn::make('notations')
                    ->label('Notations')
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state),
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
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }
}
