<?php

namespace App\Filament\CMS\Pages;

use Filament\Pages\Page;

class EmployerForm extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.c-m-s.pages.employer-form';
}
