<?php

namespace App\Filament\CMS\Pages;

use App\Models\Client;
use App\Models\Lead;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;

class JobSeekerForm extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public ?array $data = [];

    protected static ?int $navigationSort = -1;

    protected static string $view = 'filament.c-m-s.pages.job-seeker-form';

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Personal Information')
                ->description('Lets begin with the onboarding process. Tell us a little bit about yourself.')
                ->aside()
                ->schema([
                    Grid::make(12)
                        ->schema([
                            TextInput::make('first_name')
                                ->label('First Name(s)')
                                ->required()
                                ->columnSpan(6),

                            TextInput::make('surname')
                                ->helperText('Leave this field blank if you legally have no surname')
                                ->columnSpan(6),

                            TextInput::make('preferred_name')
                                ->columnSpan(12),
                        ]),

                    Grid::make(12)
                        ->schema([
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->columnSpan(12)
                                ->helperText('We will use this email to send follow-up notifications')
                        ]),

                    Grid::make(12)
                        ->schema([
                            TextInput::make('phone')
                                ->tel()
                                ->required()
                                ->columnSpan(6),

                            TextInput::make('landline')
                                ->tel()
                                ->columnSpan(6)
                        ]),

                    Grid::make(12)
                        ->schema([
                            TextInput::make('city')
                                ->required()
                                ->columnSpan(12),

                            Select::make('referral_channel')
                                ->label('How did you find us?')
                                ->native(false)
                                ->searchable(false)
                                ->selectablePlaceholder(false)
                                ->columnSpan(6)
                                ->options([
                                    'google' => 'Google',
                                    'facebook' => 'Facebook',
                                    'friend' => 'A family member or friend told me',
                                    'ads' => 'Advertisement',
                                    'seek' => 'Seek',
                                    'other' => 'Other',
                                ]),
                        ])
                ]),

            Section::make('Employment Information')
                ->aside()
                ->schema([
                    FileUpload::make('cv_attachment')
                        ->label('Upload your CV')
                        ->helperText(
                            "Don't have your CV on hand? Don't worry, you can always send it to us at a later date!"
                        ),

                    RichEditor::make('comments')
                        ->label('Comments')
                        ->disableAllToolbarButtons()
                        ->placeholder('e.g I prefer 20 hour weeks, with no weekend involvement. I have a regular weekly GP appointment on Tuesday that requires flexibility.'),
                ]),
        ])->statePath('data');
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label('Register for Work')
                ->submit('registerJobSeeker'),
        ];
    }

    public function registerJobSeeker()
    {
        $data = $this->form->getState();

        try {
            $client = Client::whereEmail($data['email'])->first();

            if (!$client) {
                $client = Client::create([
                    'first_name' => $data['first_name'],
                    'surname' => $data['surname'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'landline' => $data['landline'],
                    'preferred_name' => $data['preferred_name'],
                    'date_of_birth' => today(),
                    'status' => 'in_acquisition',
                ]);
            }

            dd($client);
//
//            $client->leads()->create([
//                'enquiry_date' => today(),
//                'lead_method' => 'inbound',
//                'source' => 'website_submission',
//                'referral_method' => $data['referral_method'],
//            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
