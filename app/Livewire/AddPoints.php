<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Contracts\View\View;

class AddPoints extends Component implements HasForms
{
    use InteractsWithForms;
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form 
    {
        return $form
            ->schema([
                Section::make('Criteria per Category')
                    ->headerActions([
                        Action::make('Points')->label('Table of Corresponding Pts')
                            ->modalDescription('The following')
                            ->link()
                            ->icon('heroicon-o-code-bracket-square')
                            ->form(function () {
                                $SRS = [
                                    "Feather's Volunteer On-site" => '5 pts',
                                    "Feather's Volunteer Field" => "10 pts",
                                    "Feather's Volunteer Buy-Forward - Tier 1" => "5 pts",
                                    "Feather's Volunteer Buy-Forward - Tier 2" => "10 pts",
                                    "Feather's Volunteer Buy-Forward - Tier 3" => "15 pts",
                                    "Feather's Volunteer External Outreach Program" => "10 pts",
                                    "Feather's Volunteer Other activities to be released" => "5/10/15 pts",
                                ];
    
                                $HW = [
                                    'Steps Counting Tier 1 (150,000)' => '5 pts',
                                    'Steps Counting Tier 2 (174,000)' => '10 pts',
                                    'Steps Counting Tier 3 (210,000)' => '15 pts',
                                    'Brain Teasers' => '5/10/15 pts',
                                    'Mental Health' => '5/10/15 pts',
                                ];
    
                                $TW= [
                                    'Volunteers or other participations' => '5/10/15 pts',
                                    'Kudos from the clients' => '5/10/15 pts',
                                    'Trainning completion (Roots) ' => '5/10/15 pts'
                                ];
    
                                return [
                                    KeyValue::make('Social Responsibility & Sustainability')
                                        ->addable(false)
                                        ->deletable(false)
                                        ->keyLabel('Criteria')
                                        ->valueLabel('Points')
                                        ->editableKeys(false)
                                        ->editableValues(false)
                                        ->default($SRS), // Pass the associative array directly as default values
    
                                    KeyValue::make('Health & Wellness')
                                        ->addable(false)
                                        ->deletable(false)
                                        ->keyLabel('Criteria')
                                        ->valueLabel('Points')
                                        ->editableKeys(false)
                                        ->editableValues(false)
                                        ->default($HW), // Pass the associative array directly as default values
    
                                    KeyValue::make('Teamwork')
                                        ->addable(false)
                                        ->deletable(false)
                                        ->keyLabel('Criteria')
                                        ->valueLabel('Points')
                                        ->editableKeys(false)
                                        ->editableValues(false)
                                        ->default($TW), // Pass the associative array directly as default values
                                ];
                            })
                            ->slideOver()
                            ->modalCancelActionLabel('< Back')
                            ->modalSubmitAction(false),
                    ])
                    ->schema([
                        TextInput::make('added_points')
                        ->label('Points')
                        ->numeric()
                        ->readOnly()
                        ->default(0)
                        ->live(),
                        Repeater::make('Point Metrics')
                        ->schema([
                            Select::make('pillars')->label('Pillars')->options([
                                'SRS' => 'SRS',
                                'HW' => 'HW',
                                'TW' => 'TW',
                            ])->live(),
                            Select::make('criteria')->options(fn (Get $get): array => match ($get('pillars')){
                                'SRS' => [
                                    "Feather's Volunteer On-site" => "Feather's Volunteer On-site",
                                    "Feather's Volunteer Field" => "Feather's Volunteer Field",
                                    "Feather's Volunteer Buy-Forward - Tier 1" => "Feather's Volunteer Buy-Forward - Tier 1",
                                    "Feather's Volunteer Buy-Forward - Tier 2" => "Feather's Volunteer Buy-Forward - Tier 2",
                                    "Feather's Volunteer Buy-Forward - Tier 3" => "Feather's Volunteer Buy-Forward - Tier 3",
                                    "Feather's Volunteer External Outreach Program" => "Feather's Volunteer External Outreach Program",
                                    "Feather's Volunteer Other activities to be released - 5 pts" => "Feather's Volunteer Other activities to be released - 5 pts",
                                    "Feather's Volunteer Other activities to be released - 10 pts" => "Feather's Volunteer Other activities to be released - 10 pts",
                                    "Feather's Volunteer Other activities to be released - 15 pts" => "Feather's Volunteer Other activities to be released - 15 pts",
                                ],
                                'HW' => [
                                    'Steps Counting Tier 1 (150,000)' => 'Steps Counting Tier 1 (150,000)',
                                    'Steps Counting Tier 2 (174,000)' => 'Steps Counting Tier 2 (174,000)',
                                    'Steps Counting Tier 3 (210,000)' => 'Steps Counting Tier 3 (210,000)',
                                    'Brain Teasers - 5 pts' => 'Brain Teasers - 5 pts',
                                    'Brain Teasers - 10 pts' => 'Brain Teasers - 10 pts',
                                    'Brain Teasers - 15 pts' => 'Brain Teasers - 15 pts',
                                    'Mental Health - 5 pts' => 'Mental Health - 5 pts',
                                    'Mental Health - 10 pts' => 'Mental Health - 10 pts',
                                    'Mental Health - 15 pt' => 'Mental Health - 15 pts',
                                ],
                                'TW' => [
                                    'Volunteers or other participations - 5 pts' => 'Volunteers or other participations - 5 pts',
                                    'Volunteers or other participations - 10 pts' => 'Volunteers or other participations - 10 pts',
                                    'Volunteers or other participations - 15 pts' => 'Volunteers or other participations - 15 pts',
                                    'Kudos from the clients - 5 pts' => 'Kudos from the clients - 5 pts'  ,
                                    'Kudos from the clients - 10 pts' => 'Kudos from the clients - 10 pts',
                                    'Kudos from the clients - 15 pts' => 'Kudos from the clients - 15 pts',
                                    'Trainning completion (Roots) - 5 pts'  => 'Trainning completion (Roots) - 5 pts',
                                    'Trainning completion (Roots) - 10 pts' => 'Trainning completion (Roots) - 10 pts',
                                    'Trainning completion (Roots) - 15 pts' => 'Trainning completion (Roots) - 15 pts',
                                ],
                                default => [],
                            }),
                        ])
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::updateTotal($get, $set);
                        })
                        ->live()
                    ]),
            ])
            ->statePath('data');
    }

    public static function updateTotal(Get $get, Set $set){

        $criteria = [
            "Feather's Volunteer On-site" => 5,
            "Feather's Volunteer Field" => 10,
            "Feather's Volunteer Buy-Forward - Tier 1" => 5,
            "Feather's Volunteer Buy-Forward - Tier 2" => 10,
            "Feather's Volunteer Buy-Forward - Tier 3" => 15,
            "Feather's Volunteer External Outreach Program" => 10,
            "Feather's Volunteer Other activities to be released - 5 pts" => 5,
            "Feather's Volunteer Other activities to be released - 10 pts" => 10,
            "Feather's Volunteer Other activities to be released - 15 pts" => 15,
            'Steps Counting Tier 1 (150,000)' => 5,
            'Steps Counting Tier 2 (174,000)' => 10,
            'Steps Counting Tier 3 (210,000)' => 15,
            'Brain Teasers - 5 pts' => 5,
            'Brain Teasers - 10 pts' => 10,
            'Brain Teasers - 15 pts' => 15,
            'Mental Health - 5 pts' => 5,            
            'Mental Health - 10 pts' => 10,
            'Mental Health - 15 pt' => 15,
            'Volunteers or other participations - 5 pts' => 5,
            'Volunteers or other participations - 10 pts' => 10,
            'Volunteers or other participations - 15 pts' => 15,
            'Kudos from the clients - 5 pts' => 5,
            'Kudos from the clients - 10 pts' => 10,
            'Kudos from the clients - 15 pts' => 15,
            'Trainning completion (Roots) - 5 pts'  => 5,
            'Trainning completion (Roots) - 10 pts' => 10,
            'Trainning completion (Roots) - 15 pts' => 15,
        ];  

        $total = 0;

        // Retrieve all selected subcategories
        $CC = collect($get('Point Metrics'));
        $selectedcriteria = $CC->pluck('criteria');
        $count = $CC->count();

        for ($i = 0; $count > $i ; $i++){
            $text = $selectedcriteria->get($i);
            
            if (array_key_exists($text, $criteria)) {
                $total += $criteria[$text];
            }
        }

        $set('added_points', number_format(0 + $total));
    }
    
    public function create(): void
    {
        dd($this->form->getState());
    }

    public function render()
    {
        return view('livewire.add-points');
    }
}
