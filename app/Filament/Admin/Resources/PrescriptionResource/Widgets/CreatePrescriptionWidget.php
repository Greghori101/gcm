<?php

namespace App\Filament\Admin\Resources\PrescriptionResource\Widgets;

use App\Enums\BloodTypes;
use App\Enums\Genders;
use App\Models\Patient;
use App\Models\Prescription;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class CreatePrescriptionWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.admin.resources.prescription-resource.widgets.create-prescription-widget';

    protected int | string | array $columnSpan = 'full';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')
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
                        ]),
                    ])
                    ->createOptionUsing(function (array $data) {
                        $patient = Patient::create($data);

                        return $patient->getKey();
                    })
                    ->columnSpanFull(),

                Forms\Components\DatePicker::make('date')
                    ->default(Carbon::today())
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('purpose')
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
