<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\RedeemHistoryResource;
use App\Models\RedeemHistory;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class ClaimedRewards extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(RedeemHistoryResource::getEloquentQuery()->where('redeemed_status', 'Redeemed')->where('redeemed_by', auth()->user()->name))
            ->defaultPaginationPageOption(8)
            ->emptyStateHeading("You haven't redeemed anything yet")
            ->emptyStateDescription('This is still empty until you have redeemed and claimed any rewards')
            ->emptyStateIcon('heroicon-o-shopping-cart')
            ->defaultSort('created_at', 'desc')
            ->columns([
                Stack::make([
                    Stack::make([
                        ImageColumn::make('redeemed_image')
                            ->height('100%')
                            ->width('100%'),
                        TextColumn::make('redeemed_name')
                            ->searchable()
                            ->weight(FontWeight::Bold),
                    ])->grow(false),
                    TextColumn::make('redeemed_points')
                        ->size(TextColumn\TextColumnSize::Medium)
                        ->formatStateUsing(fn (RedeemHistory $record): string => __("Points: {$record->redeemed_points}")),
                    TextColumn::make('redeemed_quantity')
                        ->size(TextColumn\TextColumnSize::Medium)
                        ->formatStateUsing(fn (RedeemHistory $record): string => __("Quantity Redeemed: {$record->redeemed_quantity}")),
                ]),
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
            ]);
    }
}
