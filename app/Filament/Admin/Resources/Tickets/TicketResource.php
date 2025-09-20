<?php

namespace App\Filament\Admin\Resources\Tickets;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Tickets\Pages\ListTickets;
use App\Filament\Admin\Resources\Tickets\Pages\CreateTicket;
use App\Filament\Admin\Resources\Tickets\Pages\EditTicket;
use App\Filament\Admin\Resources\TicketResource\Pages;
use App\Filament\Admin\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-ticket';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('patient_id')
                    ->label('Patient')
                    ->relationship('patient', 'id')
                    ->searchable()
                    ->required(),
                Select::make('queue_id')
                    ->label('Queue')
                    ->relationship('queue', 'name')
                    ->searchable()
                    ->required(),
                TextInput::make('number')
                    ->label('Ticket Number')
                    ->numeric()
                    ->required(),
                DatePicker::make('ticket_date')
                    ->label('Ticket Date')
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'canceled' => 'Canceled',
                        'expired' => 'Expired',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient_info')
                    ->label('Patient')
                    ->formatStateUsing(fn($state, $record) => $record->patient ? $record->patient->firstname . ' ' . $record->patient->lastname : '-')
                    ->getStateUsing(fn($record) => $record->patient ? $record->patient->firstname . ' ' . $record->patient->lastname : '-')
                    ->sortable()
                    ->searchable(['patient.firstname', 'patient.lastname']),
                TextColumn::make('queue.name')->label('Queue')->sortable()->searchable(),
                TextColumn::make('number')->label('Ticket Number')->sortable(),
                TextColumn::make('ticket_date')->label('Ticket Date')->date()->sortable(),
                TextColumn::make('status')->label('Status')->sortable(),
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
            'index' => ListTickets::route('/'),
            'create' => CreateTicket::route('/create'),
            'edit' => EditTicket::route('/{record}/edit'),
        ];
    }
}
