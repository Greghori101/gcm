<?php

namespace App\Filament\Admin\Resources\Patients\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Models\Medicine;
use App\Models\Form as FormModel;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrescriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'prescriptions';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                DatePicker::make('date')
                    ->default(Carbon::today())
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('purpose')
                    ->required()
                    ->columnSpanFull(),
                Repeater::make('prescriptionMedicines')
                    ->relationship()
                    ->cloneable()
                    ->schema([
                        Select::make('medicine_id')
                            ->relationship('medicine', 'name')
                            ->required()
                            ->searchable(['name', 'brand', 'dosage'])

                            ->getSearchResultsUsing(function (string $search) {
                                return Medicine::query()
                                    ->select('id', 'name', 'brand', 'dosage')
                                    ->whereRaw("CONCAT(brand, ' ', name, ' ', dosage) LIKE ?", ["%{$search}%"])
                                    ->limit(10)
                                    ->get()
                                    ->mapWithKeys(fn($item) => [
                                        $item->id => "{$item->brand} / {$item->name} / {$item->form} / {$item->dosage}"
                                    ])
                                    ->toArray();
                            })
                            ->afterStateUpdated(function ($set, Get $get) {
                                $dosage = $get('medicine_id') ? Medicine::find($get('medicine_id'))?->dosage : '';
                                $set('dosage', $dosage);
                            })
                            ->preload()
                            ->optionsLimit(10)
                            ->columnSpan(3)
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->brand} / {$record->name} / {$record->form} / {$record->dosage}")
                            ->reactive(),
                        Toggle::make('is_qsp')
                            ->columnSpan(1)
                            ->inline(false)
                            ->required()
                            ->reactive(),
                        TextInput::make('quantity')
                            ->columnSpan(1)
                            ->numeric()
                            ->required(),
                        Hidden::make('dosage'),
                        Hidden::make('unit'),
                        TextInput::make('unit_text')
                            ->columnSpan(1)
                            ->required()
                            ->maxLength(255)
                            ->hidden(fn(Get $get) => $get('is_qsp'))
                            ->afterStateUpdated(function ($set, $state) {
                                $set('unit', $state);
                            }),
                        Select::make('unit_select')
                            ->options(['days' => 'days', 'months' => 'months', 'weeks' => 'weeks',])
                            ->columnSpan(1)
                            ->required()
                            ->hidden(fn(Get $get) => !$get('is_qsp'))
                            ->afterStateUpdated(function ($set, $state) {
                                $set('unit', $state);
                            }),
                        TextInput::make('qte')
                            ->numeric()
                            ->columnSpan(1)
                            ->required()
                            ->maxLength(255),
                        TextInput::make('form')
                            ->datalist(function (Get $get) {
                                $medicine = Medicine::find($get('medicine_id'));
                                if (!$medicine) {
                                    return [];
                                }

                                $notations = FormModel::where('form', $medicine->form)->first()?->notations ?? [];

                                if (is_string($notations)) {
                                    $notations = explode(',', $notations);
                                }
                                if (!is_array($notations)) {
                                    $notations = [];
                                }

                                return collect($notations)
                                    ->mapWithKeys(fn($item) => [$item => $item])
                                    ->toArray();
                            })
                            ->columnSpan(1)
                            ->required(),
                        TextInput::make('frequency')
                            ->columnSpan(1)
                            ->required()
                            ->maxLength(255),
                        Select::make('periodicity')
                            ->options(['day' => 'day', 'month' => 'month', 'week' => 'week',])
                            ->columnSpan(1)
                            ->required(),
                        TagsInput::make('conditions')
                            ->columnSpan(2)
                            ->separator(','),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
                    ->reorderable(true),


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
