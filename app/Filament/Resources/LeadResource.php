<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\LeadResource\RelationManagers;
use App\Filament\Resources\LeadResource\Tables\LeadTable;
use App\Models\Client;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $activeNavigationIcon = 'heroicon-s-bolt';

    protected static ?string $navigationGroup = 'CRM';

    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Grid::make(12)
                            ->schema([
                                Select::make('client_id')
                                    ->native(false)
                                    ->searchable()
                                    ->label('Client')
                                    ->placeholder('Search for a client by name...')
                                    ->columnSpan(12)
                                    ->options(Client::all()->pluck('name', 'id'))
                                    ->required(),
                            ]),

                        Grid::make(12)
                            ->schema([
                                DatePicker::make('enquired_at')
                                    ->label('Enquiry Date')
                                    ->columnSpan(4)
                                    ->native(false)
                                    ->default(today())
                                    ->date()
                                    ->required()
                                    ->maxDate(today()),
                            ]),


                        Grid::make(12)
                            ->schema([
                                Select::make('lead_type')
                                    ->label('Lead Method')
                                    ->columnSpan(3)
                                    ->native(false)
                                    ->searchable(false)
                                    ->options([
                                        'Inbound' => 'Inbound',
                                        'Outbound' => 'Outbound',
                                    ])
                                    ->default('Inbound')
                                    ->required()
                                    ->selectablePlaceholder(false),

                                Select::make('lead_source')
                                    ->columnSpan(5)
                                    ->label('Source')
                                    ->native(false)
                                    ->searchable(false)
                                    ->options([
                                        'General' => [
                                            'Phone' => 'Phone',
                                            'Email' => 'Email',
                                            'Website' => 'Website Submission',
                                            'Referral' => 'Referral',
                                        ],

                                        'Social Media' => [
                                            'Facebook' => 'Facebook',
                                            'LinkedIn' => 'LinkedIn',
                                        ]
                                    ])
                                    ->required()
                                    ->selectablePlaceholder(false),
                            ]),

//                        Grid::make(12)
//                            ->schema([
//                                Select::make('referral_method')
//                                    ->columnSpan(6)
//                                    ->label('How did the Client find us?')
//                                    ->native(false)
//                                    ->searchable(false)
//                                    ->options([
//                                        'google' => 'Google',
//                                        'advertisement' => 'Advertisement',
//                                        'friend' => 'Friend',
//                                        'other' => 'Other'
//                                    ]),
//                            ]),
                    ]),

                Section::make('Upload Documentation')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Grid::make(12)
                            ->schema([
                                FileUpload::make('cv_attachment')
                                    ->label('Resume / CV')
                                    ->downloadable()
                                    ->previewable(true)
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->columnSpan(8),
                            ]),

                        Grid::make(12)
                            ->schema([
                                FileUpload::make('cover_letter_attachment')
                                    ->label('Cover Letter')
                                    ->downloadable()
                                    ->previewable(true)
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->columnSpan(8),
                            ]),

                        Grid::make(12)
                            ->schema([
                                FileUpload::make('other_documents')
                                    ->helperText('A maximum of 10 files can be uploaded.')
                                    ->label('Additional Documents')
                                    ->downloadable()
                                    ->multiple()
                                    ->previewable(true)
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxFiles(10)
                                    ->columnSpan(8),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return LeadTable::table($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'view' => Pages\ViewLead::route('/{record}'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
