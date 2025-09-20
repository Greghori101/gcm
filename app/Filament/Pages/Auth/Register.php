<?php

namespace App\Filament\Pages\Auth;

use App\Enums\SubscriptionStatus;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use App\Enums\Roles;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Select;
use App\Enums\BloodTypes;
use App\Enums\Genders;
use App\Models\Plan;
use Filament\Forms\Components\TextInput;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Radio;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class Register extends \Filament\Auth\Pages\Register
{

    protected function handleRegistration(array $data): Model
    {
        // Create the user
        $user = $this->getUserModel()::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'birthdate' => $data['birthdate'],
            'phone_number' => $data['phone_number'],
            'blood_type' => $data['blood_type'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        // Assign role
        $user->assignRole($data['role']);

        // Create doctor profile
        $doctor = $user->doctor()->create([
            'specialty' => $data['specialty'],
            'national_order_number' => $data['national_order_number'],
        ]);

        // Create address for doctor
        $doctor->address()->create([
            'country' => $data['country'],
            'state' => $data['state'],
            'commune' => $data['commune'],
            'city' => $data['city'],
        ]);

        // Create subscription
        $user->subscription()->create([
            'plan_id' => $data['plan_id'],
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => SubscriptionStatus::Pending,
        ]);

        return $user;
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Hidden::make('role')->default(Roles::DOCTOR->value),
            Wizard::make([
                Step::make('Account')
                    ->schema([
                        Grid::make(2)->schema([
                            Radio::make('plan_id')
                                ->label('Choose a Plan')
                                ->options(fn() => Plan::all()->pluck('name', 'id'))
                                ->descriptions(fn() => Plan::all()->pluck('price', 'id'))
                                ->inline()
                                ->inlineLabel(false)
                                ->columnSpanFull()
                                ->required(),
                            TextInput::make('firstname')
                                ->maxLength(255)
                                ->required()
                                ->translatableTabs()
                                ->columnSpan(1),
                            TextInput::make('lastname')
                                ->maxLength(255)
                                ->required()
                                ->translatableTabs()

                                ->columnSpan(1),



                            TextInput::make('birthdate')->label('Birthdate')->type('date')->required()
                                ->columnSpan(1),
                            TagsInput::make('phone_number')
                                ->required()
                                ->separator(','),
                            Select::make('blood_type')
                                ->label('Blood Type')
                                ->options(BloodTypes::toArray())
                                ->required()
                                ->columnSpan(1),
                            Select::make('gender')
                                ->label('Gender')
                                ->options(Genders::toArray())
                                ->required()
                                ->columnSpan(1),
                            TextInput::make('email')->label('Email')->email()->required()->maxLength(255)
                                ->columnSpanFull(),
                            TextInput::make('password')->label('Password')->password()->required()->maxLength(255)
                                ->columnSpan(1),
                            TextInput::make('password_confirmation')->label('Confirm Password')->password()->required()->maxLength(255)
                                ->columnSpan(1),
                        ]),

                    ]),
                Step::make('Doctor')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('specialty')
                                ->maxLength(255)
                                ->required()
                                ->translatableTabs()
                                ->columnSpan(1),
                            TextInput::make('national_order_number')->label('National Order Number')->required()->maxLength(255)
                                ->columnSpan(1),
                            TextInput::make('country')->label('Country')->required()->maxLength(255)
                                ->columnSpan(1),
                            TextInput::make('state')->label('State')->required()->maxLength(255)
                                ->columnSpan(1),
                            TextInput::make('commune')->label('Commune')->required()->maxLength(255)
                                ->columnSpan(1),
                            TextInput::make('city')->label('City')->required()->maxLength(255)
                                ->columnSpan(1),
                        ]),

                    ]),
            ])->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm"
                    >
                        Register
                    </x-filament::button>
                BLADE))),
        ]);
    }

    protected function getFormActions(): array
    {
        return [];
    }
}
