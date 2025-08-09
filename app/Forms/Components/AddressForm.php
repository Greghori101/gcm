<?php

namespace App\Forms\Components;

use Filament\Forms;
use Illuminate\Database\Eloquent\Model;

class AddressForm extends Forms\Components\Field
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
        $relationship = $record?->{$this->getRelationship()}();

        if ($relationship === null) {
            return;
        } elseif ($address = $relationship->first()) {
            $address->update($state);
        } else {
            $relationship->updateOrCreate($state);
        }

        $record?->touch();
    }

    public function getChildComponents(): array
    {
        return [
            Forms\Components\TextInput::make('country')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('state')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('commune')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('city')
                ->required()
                ->maxLength(255),
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (AddressForm $component, ?Model $record) {
            $address = $record?->getRelationValue($this->getRelationship());

            $component->state($address ? $address->toArray() : [
                'country' => null,
                'city' => null,
                'state' => null,
                'commune' => null,
                'latitude' => null,
                'longitude' => null,
                'formatted_address' => null,
            ]);
        });

        $this->dehydrated(false);
    }

    public function getRelationship(): string
    {
        return $this->evaluate($this->relationship) ?? $this->getName();
    }
}
