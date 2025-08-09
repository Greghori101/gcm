<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TicketQueueResource\Pages;
use App\Filament\Admin\Resources\TicketQueueResource\RelationManagers;
use App\Models\TicketQueue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketQueueResource extends Resource
{
    protected static ?string $model = TicketQueue::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Queue Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('priority')
                    ->label('Priority')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Queue Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('priority')->label('Priority')->sortable(),
                Tables\Columns\TextColumn::make('waiting_count')
                    ->label('Waiting Count')
                    ->getStateUsing(fn($record) => $record->waitingCount()),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListTicketQueues::route('/'),
            'create' => Pages\CreateTicketQueue::route('/create'),
            'edit' => Pages\EditTicketQueue::route('/{record}/edit'),
        ];
    }
}
