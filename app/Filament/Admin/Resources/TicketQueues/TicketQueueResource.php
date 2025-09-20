<?php

namespace App\Filament\Admin\Resources\TicketQueues;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\TicketQueues\Pages\ListTicketQueues;
use App\Filament\Admin\Resources\TicketQueues\Pages\CreateTicketQueue;
use App\Filament\Admin\Resources\TicketQueues\Pages\EditTicketQueue;
use App\Filament\Admin\Resources\TicketQueueResource\Pages;
use App\Filament\Admin\Resources\TicketQueueResource\RelationManagers;
use App\Models\TicketQueue;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketQueueResource extends Resource
{
    protected static ?string $model = TicketQueue::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-queue-list';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Queue Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('priority')
                    ->label('Priority')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Queue Name')->sortable()->searchable(),
                TextColumn::make('priority')->label('Priority')->sortable(),
                TextColumn::make('waiting_count')
                    ->label('Waiting Count')
                    ->getStateUsing(fn($record) => $record->waitingCount()),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ListTicketQueues::route('/'),
            'create' => CreateTicketQueue::route('/create'),
            'edit' => EditTicketQueue::route('/{record}/edit'),
        ];
    }
}
