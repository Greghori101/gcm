<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;
use JaOcero\RadioDeck\Forms\Components\RadioDeck;
use Filament\Support\Enums\IconSize;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\IconPosition;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                RadioDeck::make('name')
                    ->options([
                        'ios' => 'iOS',
                        'android' => 'Android',
                        'web' => 'Web',
                        'windows' => 'Windows',
                        'mac' => 'Mac',
                        'linux' => 'Linux',
                    ])
                    ->descriptions([
                        'ios' => 'iOS Mobile App',
                        'android' => 'Android Mobile App',
                        'web' => 'Web App',
                        'windows' => 'Windows Desktop App',
                        'mac' => 'Mac Desktop App',
                        'linux' => 'Linux Desktop App',
                    ])
                    ->icons([
                        'ios' => 'heroicon-m-device-phone-mobile',
                        'android' => 'heroicon-m-device-phone-mobile',
                        'web' => 'heroicon-m-globe-alt',
                        'windows' => 'heroicon-m-computer-desktop',
                        'mac' => 'heroicon-m-computer-desktop',
                        'linux' => 'heroicon-m-computer-desktop',
                    ])
                    ->required()
                    ->iconSize(IconSize::Large) // Small | Medium | Large | (string - sm | md | lg)
                    ->iconSizes([ // Customize the values for each icon size
                        'sm' => 'h-12 w-12',
                        'md' => 'h-14 w-14',
                        'lg' => 'h-16 w-16',
                    ])
                    ->iconPosition(IconPosition::Before) // Before | After | (string - before | after)
                    ->alignment(Alignment::Center) // Start | Center | End | (string - start | center | end)
                    ->gap('gap-5') // Gap between Icon and Description (Any TailwindCSS gap-* utility)
                    ->padding('px-4 px-6') // Padding around the deck (Any TailwindCSS padding utility)
                    ->direction('column') // Column | Row (Allows to place the Icon on top)
                    ->extraCardsAttributes([ // Extra Attributes to add to the card HTML element
                        'class' => 'rounded-xl'
                    ])
                    ->extraOptionsAttributes([ // Extra Attributes to add to the option HTML element
                        'class' => 'text-3xl leading-none w-full flex flex-col items-center justify-center p-4'
                    ])
                    ->extraDescriptionsAttributes([ // Extra Attributes to add to the description HTML element
                        'class' => 'text-sm font-light text-center'
                    ])
                    ->color('primary') // supports all color custom or not
                    ->multiple(),
                TextInput::make('username')
                    ->required()
                    ->maxLength(255),
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
