<?php

namespace App\Filament\Admin\Resources\Forms;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Forms\Pages\ListForms;
use App\Filament\Admin\Resources\Forms\Pages\CreateForm;
use App\Filament\Admin\Resources\Forms\Pages\EditForm;
use App\Filament\Admin\Resources\FormResource\Pages;
use App\Filament\Admin\Resources\FormResource\RelationManagers;
use App\Models\Form as FormModel;
use App\Models\Medicine;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-beaker';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Select::make('form')
                    ->options(fn() => Medicine::query()
                        ->select('form')
                        ->distinct()
                        ->pluck('form', 'form')
                        ->toArray())
                    ->columnSpan(1)
                    ->required(),

                TagsInput::make('notations')
                    ->columnSpan(1)
                    ->required()
                    ->separator(','),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('form')
                    ->label('Form')
                    ->searchable(),
                TextColumn::make('notations')
                    ->label('Notations')
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state),
            ])
            ->filters([
                //
            ])
            ->recordActions([
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
            'index' => ListForms::route('/'),
            'create' => CreateForm::route('/create'),
            'edit' => EditForm::route('/{record}/edit'),
        ];
    }
}
