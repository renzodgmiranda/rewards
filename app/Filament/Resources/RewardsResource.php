<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RewardsResource\Pages;
use App\Filament\Resources\RewardsResource\RelationManagers;
use App\Models\RedeemHistory;
use App\Models\Rewards;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
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
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                        ->formatStateUsing(fn (Rewards $record): string => __("Points: {$record->rewards_points}")),
                    TextColumn::make('rewards_quantity')
                        ->size(TextColumn\TextColumnSize::Medium)
                        ->formatStateUsing(fn (Rewards $record): string => __("In Stock: {$record->rewards_quantity}")),
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

                    return 'heroicon-o-gift';

                })
                ->color(function(Rewards $reward) {
                    $user = Auth::user();

                    if($reward->rewards_quantity == 0){
                        return 'gray';
                    }

                    elseif($user->points < $reward->rewards_points){
                        return 'danger';
                    }

                    return 'success';

                })
                ->label(function(Rewards $reward) {
                    $user = Auth::user();

                    if($reward->rewards_quantity == 0){
                        return 'Out of Stock';
                    }

                    elseif($user->points < $reward->rewards_points){
                        return 'Insufficient Points';
                    }

                    return 'Redeem';

                })
                ->form([
                    TextInput::make('quantity')->label('How many do you want to redeem?')->numeric()->default(1),
                    Placeholder::make('')
                        ->content(function (Get $get, Rewards $rewards){
                            if ($get('quantity') > $rewards->rewards_quantity){
                                return 'Cannot Redeem more than the available Stock';
                            }
                        })
                ])
                ->action(function(Rewards $reward, RedeemHistory $redeemHistory, array $data){

                    $user = Auth::user();

                    $cost = $reward->rewards_points * $data['quantity'];
                    $totalPts = $user->points;

                    if($user->points >= $cost && $reward->rewards_quantity >= $data['quantity']){

                        $user->update([
                            'points' => $totalPts - $cost,
                            'used_points' => $user->used_points + $cost,
                        ]);

                        $quantity = $reward->rewards_quantity;
                        $value = $quantity - $data['quantity'];

                        $reward->update([
                            'rewards_quantity' => $value
                        ]);

                        $redeemHistory->create([
                            'redeemed_name' => $reward->rewards_name,
                            'redeemed_image' => $reward->rewards_image,
                            'redeemed_points' => $cost,
                            'redeemed_quantity' => $data['quantity'],
                            'redeemed_status' => 'Unclaimed',
                            'redeemed_by' => $user->name,

                        ]);

                        Notification::make()
                            ->title(fn (Rewards $record): string => __("Successfully Redeemed {$record->rewards_name}"))
                            ->success()
                            ->send();

                        //Mail::to($vendor->email)->send(new WorkorderAssigned($workorder));
                    }                   

                    elseif($user->points < $cost){
                        Notification::make()
                        ->title(fn (): string => __("Insuffcient Points"))
                        ->danger()
                        ->send();
                    }

                    elseif($reward->rewards_quantity < $data['quantity']){
                        Notification::make()
                        ->title(fn (): string => __("Quantity given is higher than Stock"))
                        ->danger()
                        ->send();
                    }
                        
                    

                })
                ->disabled(function (Rewards $reward) {
                    $user = Auth::user();

                    if($reward->rewards_quantity == 0) {
                        return true;
                    }
                    elseif($user->points < $reward->rewards_points){
                        return true;
                    }

                    return false;
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
