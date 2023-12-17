<?php

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class ClientForm
{
    /**
     * Generate the form for creating a new Client.
     * 
     * @return Form
     */
    public static function render(Form $form)
    {
        return $form->schema([
            Section::make()
                ->schema([
                    Grid::make(12)
                        ->schema([
                            TextInput::make('first_name')
                                ->label('First Name(s)')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(6),

                            TextInput::make('surname')
                                ->nullable()
                                ->maxLength(255)
                                ->columnSpan(6),

                            TextInput::make('preferred_name')
                                ->nullable()
                                ->maxLength(255)
                                ->columnSpan(6)
                        ]),

                    Grid::make(12)
                        ->schema([
                            TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(6)
                        ]),

                    Grid::make(12)
                        ->schema([
                            TextInput::make('phone')
                                ->label('Mobile Phone')
                                ->tel()
                                ->required()
                                ->columnSpan(6),

                            TextInput::make('landline')
                                ->tel()
                                ->nullable()
                                ->columnSpan(6)
                        ]),

                    Grid::make(12)
                        ->schema([
                            DatePicker::make('date_of_birth')
                                ->date()
                                ->native(true)
                                ->required()
                                ->format('d/m/Y')
                                ->displayformat('d/m/Y')
                                ->columnSpan(4),
                        ])
                ])
        ]);
    }
}