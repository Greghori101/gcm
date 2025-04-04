<?php

namespace App\Forms\Components;

use App\Enums\BloodTypes;
use App\Enums\Genders;
use App\Models\Patient;
use App\Models\User;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class PatientForm extends Forms\Components\Field
{
    protected string $view = 'filament-forms::components.group';

    /** @var string|callable|null */
    public $relationship = null;

    public function relationship(string | callable $relationship): static
    {
        $this->relationship = $relationship;

        return $this;
    }

    public function saveRelationships(): void
    {
        $state = $this->getState();
        $record = $this->getRecord();

        if (!$record) {
            return;
        }
        if ($record->patient) {
            $record->patient->user->update($state);
        } else {
            $state['password'] = Hash::make('password');
            $user = User::updateOrCreate(['phone_number' => $state['phone_number']], $state);
            $patient = $user->patient ?? Patient::create([]);

            $user->patient()->save($patient);

            $record->patient_id = $patient->id;
            $record->save();
        }

        $record->touch();
    }


    public function getChildComponents(): array
    {
        return [
            Forms\Components\Grid::make()->columns(2)->schema([
                Forms\Components\TextInput::make('firstname')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),
                Forms\Components\TextInput::make('lastname')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),
                Forms\Components\DatePicker::make('birthdate')
                    ->required()
                    ->columnSpan(1),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required()
                    ->maxLength(255)
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

        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (PatientForm $component, ?Model $record) {
            $patient = $record?->getRelationValue($this->getRelationship());

            $component->state($patient ? $patient->user->toArray() : [
                'firstname' => null,
                'lastname' => null,
                'birthdate' => null,
                'phone_number' => null,
                'blood_type' => null,
                'gender' => null,
            ]);
        });

        $this->dehydrated(false);
    }

    public function getRelationship(): string
    {
        return $this->evaluate($this->relationship) ?? $this->getName();
    }
}
