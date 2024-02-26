<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\RewardsResource;
use App\Models\Rewards as Reward;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class Rewards extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(RewardsResource::getEloquentQuery())
            ->defaultPaginationPageOption(8)
            ->defaultSort('created_at', 'desc')
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
                        ->formatStateUsing(fn (Reward $record): string => __("Points: {$record->rewards_points}")),
                    TextColumn::make('rewards_quantity')
                        ->size(TextColumn\TextColumnSize::Medium)
                        ->formatStateUsing(fn (Reward $record): string => __("In Stock: {$record->rewards_quantity}")),
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