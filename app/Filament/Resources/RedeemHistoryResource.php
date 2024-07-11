<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RedeemHistoryResource\Pages;
use App\Filament\Resources\RedeemHistoryResource\RelationManagers;
use App\Models\RedeemHistory;
use App\Models\Rewards;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Action as ActionsAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RedeemHistoryResource extends Resource
{
    protected static ?string $model = RedeemHistory::class;

    public static ?string $label = 'Redeem Records';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading("You have no records of any merch redeems yet")
            ->poll('5s')
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                if($user->hasRole('Employee')) {
                    $query->where('redeemed_by', $user->name);
                }

                return $query;
            })
            ->columns([
                TextColumn::make('redeemed_quantity')->label('Quantity'),
                TextColumn::make('redeemed_name')->label('Item')
                ->searchable(),
                ImageColumn::make('redeemed_image')->label(''),
                TextColumn::make('redeemed_points')->label('Points'),
                TextColumn::make('redeemed_by')
                ->searchable()
                ->visible(function () {
                    $user = Auth::user();

                    if($user->hasAnyRole(['Admin'])) {
                        return true;
                    }

                    return false;
                }),
                TextColumn::make('created_at')->label('Redeemed at'),
                TextColumn::make('redeemed_status')->label('Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Processing' => 'warning',
                    'Redeemed' => 'success',
                    'Unclaimed' => 'danger',
                }),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    // ...
                ->indicateUsing(function (array $data): array {
                    $indicators = [];

                    if ($data['from'] ?? null) {
                        $indicators[] = Indicator::make('Created from ' . Carbon::parse($data['from'])->toFormattedDateString())
                            ->removeField('from');
                    }

                    if ($data['until'] ?? null) {
                        $indicators[] = Indicator::make('Created until ' . Carbon::parse($data['until'])->toFormattedDateString())
                            ->removeField('until');
                    }

                    return $indicators;
                })
                ->query(function (Builder $query, array $data) {
                    if (isset($data['from']) && isset($data['until'])) {
                        $query->whereBetween('audit_date', [
                            $data['from'],
                            $data['until'],
                        ]);
                    }
                })
            ])
            ->actions([
                Action::make('change_status')
                ->button()
                ->visible(function () {
                    $user = Auth::user();

                    if($user->hasAnyRole(['Admin'])) {
                        return true;
                    }

                    return false;
                })
                ->form([
                    Select::make('redeemed_status')->label('Change Status')
                        ->options([
                            'Processing' => 'Processing',
                            'Redeemed' => 'Redeemed',
                            'Unclaimed' => 'Unclaimed',
                        ])
                ])
                ->action(fn(RedeemHistory $record, $data) => $record->changeStatus($data, $record)), //changeStatus function in model

                //undo action
                Action::make('Undo')
                    ->button()
                    ->requiresConfirmation()
                    ->visible(function(RedeemHistory $status){

                        if($status->redeemed_status === 'Redeemed' || $status->redeemed_status === 'Unclaimed'){
                            return false;
                        }

                        return true;
                    })
                    ->action(function(RedeemHistory $status){
                        $item = Rewards::where('rewards_name', '=', $status->redeemed_name)->where('id', $status->rewards_id)->first();
                        $pts = $status->redeemed_points;
                        $user = User::where('name', '=', $status->redeemed_by)->where('id', $status->user_id)->first();

                        if($user){
                            $user->update([
                                'points' => $user->points + $pts,
                                'used_points' => $user->used_points - $pts,
                            ]);

                            $item->update([
                                'rewards_quantity' => $item->rewards_quantity + $status->redeemed_quantity
                            ]);
                            $status->delete();
                        }
                    }),
            ])
            ->bulkActions([
               BulkActionGroup::make([
                BulkAction::make('change_unclaimed')
                ->label('Change Status to Unclaimed')
                ->deselectRecordsAfterCompletion()
                ->visible(function () {
                    $user = Auth::user();

                    if($user->hasAnyRole(['Admin'])) {
                        return true;
                    }

                    return false;
                })
                ->action(function(Collection $records){

                    $records->each(function($records){

                        $records->update([
                            'redeemed_status' => "Unclaimed"
                        ]);

                        Notification::make()
                                ->title(fn (): string => __("Successfully Changed Status to Unclaimed"))
                                ->success()
                                ->send();

                    });
                }),

                BulkAction::make('change_redeemed')
                ->label('Change Status to Redeemed')
                ->icon('heroicon-o-check-circle')
                ->deselectRecordsAfterCompletion()
                ->visible(function () {
                    $user = Auth::user();

                    if($user->hasAnyRole(['Admin'])) {
                        return true;
                    }

                    return false;
                })
                ->action(function(Collection $records){

                    $records->each(function($records){
                        $redeemer = $records->redeemed_by;

                        $user = User::where('name', '=', $redeemer)->first();

                        $records->update([
                            'redeemed_status' => "Redeemed"
                        ]);

                        $user->update([
                            'items_redeemed' => $user->items_redeemed + 1
                        ]);

                        Notification::make()
                                ->title(fn (): string => __("Successfully Changed Status to Redeemed"))
                                ->success()
                                ->send();

                    });
                }),
               ])
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Section::make('Info')->schema([
                TextEntry::make('redeemed_name')->label('Item'),
                TextEntry::make('redeemed_points')->label('Points'),
                TextEntry::make('redeemed_quantity')->label('Quantity'),
                TextEntry::make('redeemed_by')->label('Redeemed By'),
                TextEntry::make('created_at')->label('Redeemed at'),
                TextEntry::make('redeemed_user_note')->label('Note from the user')
            ])->columnSpan(1),
            Section::make('Status')->schema([
                TextEntry::make('redeemed_status')->label('')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Processing' => 'warning',
                    'Redeemed' => 'success',
                    'Unclaimed' => 'danger',
                }),
            ])->columnSpan(1)
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
            'index' => Pages\ListRedeemHistories::route('/'),
            'create' => Pages\CreateRedeemHistory::route('/create'),
            'edit' => Pages\EditRedeemHistory::route('/{record}/edit'),
            'view' => Pages\ViewRedeemHistory::route('/{record}')
        ];
    }
}
