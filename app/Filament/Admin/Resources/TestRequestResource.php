<?php

namespace App\Filament\Admin\Resources;

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
use Filament\Forms\Form;
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

    protected static ?string $navigationIcon = 'fontisto-test-tube';

    public static function form(Form $form): Form
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
                Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'id')
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\Grid::make()->columns(2)->schema([
                            TranslatableContainer::make(
                                Forms\Components\TextInput::make('firstname')
                                    ->maxLength(255)
                                    ->required()
                            )
                                ->onlyMainLocaleRequired()
                                ->requiredLocales(['fr', 'ar']),
                            TranslatableContainer::make(
                                Forms\Components\TextInput::make('lastname')
                                    ->maxLength(255)
                                    ->required()
                            )
                                ->onlyMainLocaleRequired()
                                ->requiredLocales(['fr', 'ar']),
                            Forms\Components\DatePicker::make('birthdate')
                                ->required()
                                ->columnSpan(1),
                            Forms\Components\TagsInput::make('phone_number')
                                ->required()
                                ->separator(',')
                                ->columnSpan(1),
                            Forms\Components\Select::make('blood_type')
                                ->options(BloodTypes::toArray())
                                ->required()
                                ->columnSpan(1),
                            Forms\Components\Select::make('gender')
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
                Tables\Columns\TextColumn::make('patient_info')
                    ->label('Patient')
                    ->formatStateUsing(fn($state, $record) => $record->patient ? $record->patient->firstname . ' ' . $record->patient->lastname : '-')
                    ->getStateUsing(fn($record) => $record->patient ? $record->patient->firstname . ' ' . $record->patient->lastname : '-')
                    ->searchable(['patient.firstname', 'patient.lastname']),
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
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn(TestRequest $record) => route('test-request-pdf', $record))
                    ->openUrlInNewTab(),
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
