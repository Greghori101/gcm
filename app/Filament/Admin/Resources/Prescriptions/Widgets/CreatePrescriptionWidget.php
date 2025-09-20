<?php

namespace App\Filament\Admin\Resources\Prescriptions\Widgets;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use App\Enums\BloodTypes;
use App\Enums\Genders;
use App\Models\Patient;
use App\Models\Prescription;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class CreatePrescriptionWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.admin.resources.prescription-resource.widgets.create-prescription-widget';

    protected int | string | array $columnSpan = 'full';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('patient_id')
                    ->label('Patient')
                    ->options(
                        Patient::query()
                            ->get()
                            ->mapWithKeys(fn(Patient $patient) => [
                                $patient->id => "{$patient->firstname} {$patient->lastname}",
                            ])
                    )
                    ->searchable()
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
                        ]),
                    ])
                    ->createOptionUsing(function (array $data) {
                        $patient = Patient::create($data);

                        return $patient->getKey();
                    })
                    ->columnSpanFull(),

                DatePicker::make('date')
                    ->default(Carbon::today())
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('purpose')
                    ->required()
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $prescription = Prescription::create($this->form->getState());
        $this->form->fill();
        $this->redirect("/admin/prescriptions/{$prescription->id}");
    }
}
