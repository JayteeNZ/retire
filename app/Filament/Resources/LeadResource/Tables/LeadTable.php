<?php

namespace App\Filament\Resources\LeadResource\Tables;

use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Support\Assets\Theme;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

abstract class LeadTable
{
    private static function getColumns(): array
    {
        return [

            TextColumn::make('name')
                ->weight(FontWeight::SemiBold)
                ->searchable(),

            TextColumn::make('enquired_at')
                ->label('Enquiry Date')
                ->date('d/m/Y')
                ->sortable(),

            TextColumn::make('email')
                ->copyable()
                ->searchable(),

            TextColumn::make('phone')
                ->copyable()
                ->searchable(),

            TextColumn::make('source')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('status')
                ->badge()
                ->color(fn ($record) => $record->status === 'Open' ? 'primary' : 'danger'),
        ];
    }

    private static function getFilters(): array
    {
        return [
            SelectFilter::make('customer_type')
                ->label('Enquiry Type')
                ->options([
                    \App\Models\Client::class => 'Potential Client',
                    \App\Models\Employer::class => 'Potential Employer',
                ]),
        ];
    }

    private static function getActions(): array
    {
        return [
            ActionGroup::make([])
                ->icon('heroicon-m-ellipsis-horizontal')
                ->color('info')
                ->actions([
                    \Filament\Tables\Actions\Action::make('dispatch_email')
                        ->icon('heroicon-s-link')
                        ->label('Send Email'),
                    ViewAction::make(),
                    \Filament\Tables\Actions\Action::make('convert_lead')
                        ->requiresConfirmation()
                        ->icon('heroicon-s-play')
                        ->color('primary')
                        ->label('Convert'),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
        ];
    }

    private static function getBulkActions(): array
    {
        return [
            BulkActionGroup::make([
                BulkAction::make('change_status')
                    ->label('Update Lead Status')
                    ->requiresConfirmation()
                    ->icon('heroicon-s-check-circle'),

                BulkAction::make('convert')
                    ->requiresConfirmation()
                    ->icon('heroicon-s-play')
                    ->color('primary'),

                BulkAction::make('dispatch_email')
                    ->icon('heroicon-s-link')
                    ->label('Send Email'),

                DeleteBulkAction::make()
            ])
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('30s')
            ->persistColumnSearchesInSession()
            ->striped()
            ->emptyStateHeading('No matching records!')
            ->emptyStateDescription("Whoops! Looks like there aren't any leads matching the search criteria :(")
            ->columns(static::getColumns())
            ->defaultPaginationPageOption(25)
            ->groups([
                Group::make('enquired_at')
                    ->label('Enquiry Date')
                    ->date(),
            ])
            ->toggleColumnsTriggerAction(
                fn (\Filament\Tables\Actions\Action $action) => $action
                    ->button()
                    ->label('Columns')
            )
            ->filters(static::getFilters())
            ->filtersTriggerAction(
                fn (\Filament\Tables\Actions\Action $action) => $action
                    ->button()
                    ->label('Filters'),
            )
            ->actions(static::getActions())
            ->bulkActions(static::getBulkActions());
    }
}
