<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use App\Models\Lead;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    public ?string $activeTab = 'active';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create New Lead'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'active' => Tab::make('Active')
                ->badge(Lead::whereIn('status', ['active', 'open', 'pending'])->count()),

            'conversions' => Tab::make('Won/Converted')
                ->badge(Lead::whereIn('status', ['won', 'converted', 'converted_client', 'converted_employer'])->count()),

            'converted_client' => Tab::make('Converted as Client')
                ->badgeColor('info')
                ->badge(
                    Lead::whereIn('status', ['converted_client'])->count()
                ),

            'converted_employer' => Tab::make('Converted as Employer')
                ->badgeColor('info')
                ->badge(
                    Lead::whereIn('status', ['converted_employer'])->count()
                ),

            'closed' => Tab::make('Lost/Closed')
                ->badgeColor('danger')
                ->badge(
                    Lead::whereIn('status', ['lost', 'closed', 'withdrawn'])->count()
                ),

            'all' => Tab::make('All Leads')
                ->badge(Lead::count())
                ->badgeColor('gray'),
        ];
    }
}
