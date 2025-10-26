<?php

namespace App\Filament\Admin\Resources\Patients\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CertificatesRelationManager extends RelationManager
{
    protected static string $relationship = 'certificates';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('period')
                    ->required()
                    ->maxLength(255),
                TextInput::make('signature')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('date')
                    ->default(Carbon::today())
                    ->required(),
                Textarea::make('purpose')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nb')
            ->columns([
                TextColumn::make('nb'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()->authorize(true),

            ])
            ->recordActions([
                ViewAction::make()->authorize(true),
                EditAction::make()->authorize(true),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
