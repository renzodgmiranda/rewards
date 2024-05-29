<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\BadgeBoardResource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class Badges extends BaseWidget
{
    public function table(Table $table): Table
    {
        $user = auth()->user()->id;

        return $table
            ->query(BadgeBoardResource::getEloquentQuery()->where('badge_owner', $user))
            ->emptyStateHeading("You have no badges yet")
            ->emptyStateIcon('heroicon-o-trophy')
            ->columns([
                Stack::make([
                    Stack::make([
                        ImageColumn::make('badge_image')
                            ->height('100%')
                            ->width('100%')
                            ->alignCenter(),
                        TextColumn::make('badge_name')
                            ->searchable()
                            ->alignCenter()
                            ->weight(FontWeight::Bold),
                    ])->grow(false),
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
            ]);
    }
}
