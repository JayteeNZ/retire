<?php

namespace App\Filament\Resources\LeadResource\Forms;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

abstract class LeadForm
{
    public static function make(Form $form): Form
    {
        return $form->schema(static::toArray());
    }

    public static function toArray(): array
    {
        return [
            Section::make()
                ->schema([
                    Grid::make(12)
                        ->schema([

                        ])
                ])
        ];
    }
}
