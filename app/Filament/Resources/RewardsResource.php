<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RewardsResource\Pages;
use App\Filament\Resources\RewardsResource\RelationManagers;
use App\Mail\RewardsRedeemed;
use App\Models\RedeemHistory;
use App\Models\Rewards;
use App\Models\User;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RewardsResource extends Resource
{
    protected static ?string $model = Rewards::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('rewards_name')->label('Item Name'),
                        FileUpload::make('rewards_image')
                            ->disk('public')
                            ->directory('images')
                            ->preserveFilenames()
                            ->imageResizeMode('force')
                            ->imageCropAspectRatio('1:1'),
                        TextInput::make('rewards_points')->label('Points to Redeem')
                            ->numeric(),
                        TextInput::make('rewards_quantity')->label('Quantity')
                            ->numeric(),
                        Select::make('rewards_tier')->label('Tier Required')
                        ->options([
                            'Bronze' => 1,
                            'Silver' => 2,
                            'Gold' => 3,
                            'Platinum' => 4
                        ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('rewards_tier')
            ->defaultSort('rewards_points', 'asc')
            ->emptyStateHeading("No merch has been set up yet")
            ->columns([
                Stack::make([
                    Stack::make([
                        ImageColumn::make('rewards_image')
                            ->height('100%')
                            ->width('100%'),
                        TextColumn::make('rewards_name')
                            ->searchable()
                            ->weight(FontWeight::Bold),
                    ])->grow(false),
                    TextColumn::make('rewards_points')
                        ->size(TextColumn\TextColumnSize::Medium)
                        ->formatStateUsing(fn (Rewards $record): string => __("Points: {$record->rewards_points} Pts")),
                    TextColumn::make('rewards_quantity')
                        ->size(TextColumn\TextColumnSize::Medium)
                        ->formatStateUsing(fn (Rewards $record): string => __("In Stock: {$record->rewards_quantity}")),
                    TextColumn::make('rewards_tier')
                        ->size(TextColumn\TextColumnSize::Medium)
                        ->formatStateUsing(function (Rewards $record){
                            if($record->rewards_tier == 1){
                                return __("Tier Required: Bronze");
                            }
                            elseif($record->rewards_tier == 2){
                                return __("Tier Required: Silver");
                            }
                            elseif($record->rewards_tier == 3){
                                return __("Tier Required: Gold");
                            }
                            elseif($record->rewards_tier == 4){
                                return __("Tier Required: Platinum");
                            }
                            else{
                                return '';
                            }
                        })
                        ->badge()
                        ->color('primary'),
                ]),
            ])
            ->filters([
                //
            ])

            ->contentGrid([
                'md' => 3,
                'xl' => 4,

            ])

            ->paginated([
                18,
                36,
                72,
                'all',
            ])

            ->actions([
                Action::make('Redeem')
                ->icon(function(Rewards $reward) {
                    $user = Auth::user();

                    if($reward->rewards_quantity == 0){
                        return 'heroicon-o-exclamation-circle';
                    }

                    elseif($user->points < $reward->rewards_points){
                        return 'heroicon-o-x-circle';
                    }

                    elseif($user->tier < $reward->rewards_tier){
                        return 'heroicon-o-arrow-down-circle';
                    }

                    else{
                        return 'heroicon-o-gift';
                    }

                })
                ->color(function(Rewards $reward) {
                    $user = Auth::user();

                    if($reward->rewards_quantity == 0){
                        return 'gray';
                    }

                    elseif($user->points < $reward->rewards_points){
                        return 'danger';
                    }

                    elseif($user->tier < $reward->rewards_tier){
                        return 'danger';
                    }

                    else{
                        return 'success';
                    }

                })
                ->label(function(Rewards $reward) {
                    $user = Auth::user();

                    if($reward->rewards_quantity == 0){
                        return 'Out of Stock';
                    }

                    elseif($user->points < $reward->rewards_points){
                        return 'Insufficient Points';
                    }

                    elseif($user->tier < $reward->rewards_tier){
                        return 'Tier too low';
                    }

                    else{
                        return 'Redeem';
                    }

                })
                ->form([
                    TextInput::make('quantity')->label('How many do you want to redeem?')->numeric()->default(1),
                    Textarea::make('note')->label('Note (this is for redeeming any clothing or items that may vary in size)')

                ])
                ->action(function($record, $data){
                    $redeem = $record->redeem($record, $data);

                    return $redeem;
                })
                ->disabled(function (Rewards $reward) {
                    $user = Auth::user();

                    if($reward->rewards_quantity == 0) {
                        return true;
                    }
                    elseif($user->points < $reward->rewards_points){
                        return true;
                    }

                    elseif($user->tier < $reward->rewards_tier){
                        return true;
                    }

                    return false;
                }),
                Action::make('wishlist')->label('Add to Wishlist')
                ->visible(function(Rewards $reward){
                    if($reward->rewards_quantity == 0){
                        return true;
                    }
                    else{
                        return false;
                    }
                })
                ->action(function($record){
                    return $record->addToWishlist($record);
                }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

            ]);
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
            'index' => Pages\ListRewards::route('/'),
            'create' => Pages\CreateRewards::route('/create'),
            'edit' => Pages\EditRewards::route('/{record}/edit'),
        ];
    }
}
