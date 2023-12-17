<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use Filament\Actions;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewLead extends ViewRecord
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\ActionGroup::make([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
                ->button()
                ->outlined()
                ->color('gray')
                ->label('Manage Lead'),

            Actions\Action::make('convert')
                ->label('Convert to Client')
                ->icon('heroicon-m-check-circle'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Tabs::make('')
                ->columnSpanFull()
                ->tabs([
                    Tabs\Tab::make('Lead Information'),
                    Tabs\Tab::make('Attachments'),
                    Tabs\Tab::make('Admin Log'),
                ])
        ]);
    }

    public function getTitle(): string|Htmlable
    {
        $id = $this->getRecord()->id;
        $type = $this->getRecord()->customer_type == \App\Models\Client::class ? 'Client' : 'Employer';
        return $this->getRecord()->name . " ({$type})";
    }

    public function getSubheading(): string|Htmlable|null
    {
        return $this->getRecord()->enquired_at->format('d/m/Y (D)');
    }
}
