<?php

namespace App\Filament\Admin\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\TestRequestResource\Pages\ListTestRequests;
use App\Filament\Admin\Resources\TestRequestResource\Pages\CreateTestRequest;
use App\Filament\Admin\Resources\TestRequestResource\Pages\ViewTestRequest;
use App\Filament\Admin\Resources\TestRequestResource\Pages\EditTestRequest;
use App\Enums\BloodTypes;
use App\Enums\Genders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;
use Carbon\Carbon;
use App\Filament\Admin\Resources\TestRequestResource\Pages;
use App\Filament\Admin\Resources\TestRequestResource\RelationManagers;
use App\Models\TestRequest;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class TestRequestResource extends Resource
{
    protected static ?string $model = TestRequest::class;

    protected static ?int $navigationSort = 7;

    protected static string | \BackedEnum | null $navigationIcon = 'fontisto-test-tube';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('past_medical_history')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('visit_purpose')
                    ->required()
                    ->maxLength(255),
                TextInput::make('conclusion')
                    ->required()
                    ->maxLength(255),
                Textarea::make('requests')
                    ->required()
                    ->columnSpanFull(),
                DatePicker::make('date')
                    ->default(Carbon::today())
                    ->required(),
                Textarea::make('purpose')
                    ->required(),
                Select::make('patient_id')
                    ->relationship('patient', 'id')
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Grid::make()->columns(2)->schema([
                            TranslatableContainer::make(
                                TextInput::make('firstname')
                                    ->maxLength(255)
                                    ->required()
                            )
                                ->onlyMainLocaleRequired()
                                ->requiredLocales(['fr', 'ar']),
                            TranslatableContainer::make(
                                TextInput::make('lastname')
                                    ->maxLength(255)
                                    ->required()
                            )
                                ->onlyMainLocaleRequired()
                                ->requiredLocales(['fr', 'ar']),
                            DatePicker::make('birthdate')
                                ->required()
                                ->columnSpan(1),
                            TagsInput::make('phone_number')
                                ->required()
                                ->separator(',')
                                ->columnSpan(1),
                            Select::make('blood_type')
                                ->options(BloodTypes::toArray())
                                ->required()
                                ->columnSpan(1),
                            Select::make('gender')
                                ->options(Genders::toArray())
                                ->required()
                                ->columnSpan(1),
                        ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nb')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('visit_purpose')
                    ->searchable(),
                TextColumn::make('conclusion')
                    ->searchable(),
                TextColumn::make('patient_info')
                    ->label('Patient')
                    ->formatStateUsing(fn($state, $record) => $record->patient ? $record->patient->firstname . ' ' . $record->patient->lastname : '-')
                    ->getStateUsing(fn($record) => $record->patient ? $record->patient->firstname . ' ' . $record->patient->lastname : '-')
                    ->searchable(['patient.firstname', 'patient.lastname']),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn(TestRequest $record) => route('test-request-pdf', $record))
                    ->openUrlInNewTab(),
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
            'index' => ListTestRequests::route('/'),
            'create' => CreateTestRequest::route('/create'),
            'view' => ViewTestRequest::route('/{record}'),
            'edit' => EditTestRequest::route('/{record}/edit'),
        ];
    }
}
