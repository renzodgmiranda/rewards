<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('email'),
                Select::make('roles')
                    ->default('Employee')
                    ->native(false)
                    ->relationship('roles', 'name')
                    ->live(),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state)),
                TextInput::make('account'),
                Select::make('tier')->options([
                    'Tier 1' => 'Tier 1',
                    'Tier 2' => 'Tier 2',
                    'Tier 3' => 'Tier 3',
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('roles.name'),
                TextColumn::make('account'),
                TextColumn::make('points'),
                TextColumn::make('tier')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Add Points')
                ->modalDescription('Place the amount of points to be added to the User')
                ->button()
                ->form([
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
                ->action(function(array $data, User $user){
                    $totalPts = $user->points;
                    $srsPts = $user->srs_points;
                    $hwPts = $user->hw_points;
                    $twPts = $user->tw_points;
                    $q1Pts = $user->q1_points;
                    $q2Pts = $user->q2_points;
                    $q3Pts = $user->q3_points;
                    $q4Pts = $user->q4_points;

                    $criteriaSRS = [
                        "Feather's Volunteer On-site" => 5,
                        "Feather's Volunteer Field" => 10,
                        "Feather's Volunteer Buy-Forward - Tier 1" => 5,
                        "Feather's Volunteer Buy-Forward - Tier 2" => 10,
                        "Feather's Volunteer Buy-Forward - Tier 3" => 15,
                        "Feather's Volunteer External Outreach Program" => 10,
                        "Feather's Volunteer Other activities to be released - 5 pts" => 5,
                        "Feather's Volunteer Other activities to be released - 10 pts" => 10,
                        "Feather's Volunteer Other activities to be released - 15 pts" => 15,
                    ];

                    $criteriaHW = [
                        'Steps Counting Tier 1 (150,000)' => 5,
                        'Steps Counting Tier 2 (174,000)' => 10,
                        'Steps Counting Tier 3 (210,000)' => 15,
                        'Brain Teasers - 5 pts' => 5,
                        'Brain Teasers - 10 pts' => 10,
                        'Brain Teasers - 15 pts' => 15,
                        'Mental Health - 5 pts' => 5,            
                        'Mental Health - 10 pts' => 10,
                        'Mental Health - 15 pt' => 15,
                    ];

                    $criteriaTW = [
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

                    $addedPts = $data['added_points'];
                    $CC = $data['Point Metrics'] ?? [];
                    $selectedcriteria = collect($CC)->pluck('criteria');
                    $count = $selectedcriteria->count();

                    $addedSRS = 0;
                    $addedHW = 0;
                    $addedTW = 0;

                    for ($i = 0; $count > $i ; $i++){
                        $text = $selectedcriteria->get($i);
                        
                        if (array_key_exists($text, $criteriaSRS)) {
                            $addedSRS += $criteriaSRS[$text];
                        }
                        elseif (array_key_exists($text, $criteriaHW)) {
                            $addedHW += $criteriaHW[$text];
                        }
                        elseif (array_key_exists($text, $criteriaTW)) {
                            $addedTW += $criteriaTW[$text];
                        }
                        else{

                        }
                    }

                    $q1 = 0;
                    $q2 = 0;
                    $q3 = 0;
                    $q4 = 0;

                    $m = date('m');

                    if($m >= 1 && $m <= 3){
                        $q1 += $addedPts;
                    }
                    if($m >= 4 && $m <= 6){
                        $q2 += $addedPts;
                    }
                    if($m >= 7 && $m <= 9){
                        $q3 += $addedPts;
                    }
                    if($m >= 10 && $m <= 12){
                        $q4 += $addedPts;
                    }

                    $user->update([
                        'points' => $totalPts + $addedPts,
                        'srs_points' => $srsPts + $addedSRS,
                        'hw_points' => $hwPts + $addedHW,
                        'tw_points' => $twPts + $addedTW,
                        'q1_points' => $q1Pts + $q1,
                        'q2_points' => $q2Pts + $q2,
                        'q3_points' => $q3Pts + $q3,
                        'q4_points' => $q4Pts + $q4,
                    ]);

                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
