<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class ViewClient extends ViewRecord
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit Client'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('')
                ->schema([

                ])
        ]);
    }

    public function getTitle(): string|Htmlable
    {
        $fullName = static::getRecord()->name;
        $preferredName = static::getRecord()->preferred_name;

        if ($preferredName) {
            return new HtmlString(
                "{$fullName} &mdash; ({$preferredName})"
            );
        }

        return $fullName;
    }

    public function getBreadcrumb(): string
    {
        $id = static::getRecord()->id;

        return "#{$id}";
    }
}
