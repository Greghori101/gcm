<?php

namespace App\Filament\Admin\Resources\PrescriptionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MedicinesRelationManager extends RelationManager
{
    protected static string $relationship = 'medicines';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('interface.name')),

                Tables\Columns\TextColumn::make('pivot.quantity')
                    ->label(__('interface.quantity')),

                Tables\Columns\TextColumn::make('pivot.unit')
                    ->label(__('interface.unit')),

                Tables\Columns\TextColumn::make('pivot.posology')
                    ->label(__('interface.posology')),

                Tables\Columns\TextColumn::make('pivot.conditions')
                    ->label(__('interface.conditions')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // ...
                Tables\Actions\AttachAction::make()
                    ->form(fn(Tables\Actions\AttachAction $action): array => [
                        Forms\Components\Grid::make()
                            ->columns(3)
                            ->schema([
                                $action->getRecordSelect()->columnSpan(3),
                                Forms\Components\Toggle::make('is_qsp')
                                    ->columnSpan(1)
                                    ->inline(false)
                                    ->required(),
                                Forms\Components\TextInput::make('quantity')
                                    ->columnSpan(1)
                                    ->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('unit')
                                    ->columnSpan(1)
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('posology')
                                    ->columnSpan(1)
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TagsInput::make('conditions')
                                    ->columnSpan(2)
                                    ->required()
                                    ->separator(','),
                            ])

                    ])
            ])
            ->actions([
                // ...
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // ...
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
