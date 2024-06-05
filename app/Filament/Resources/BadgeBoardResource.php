<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BadgeBoardResource\Pages;
use App\Filament\Resources\BadgeBoardResource\RelationManagers;
use App\Models\BadgeBoard;
use App\Models\Badges;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BadgeBoardResource extends Resource
{
    protected static ?string $model = BadgeBoard::class;

    protected static ?string $navigationLabel = 'Badge Board';

    protected static ?string $navigationGroup = 'Admin';
    
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('badge_name')->label('Badge Title'),
                FileUpload::make('badge_image')->label('Badge Image')->columnSpan('full')
                ->disk('public')
                ->directory('images')
                ->preserveFilenames()
                ->imageResizeMode('force')
                ->imageCropAspectRatio('1:1'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Stack::make([
                Stack::make([
                    TextColumn::make('badge_name')
                        ->searchable()
                        ->alignCenter()
                        ->weight(FontWeight::Bold),
                    ImageColumn::make('badge_image')
                        ->height('100%')
                        ->width('100%')
                        ->alignCenter(),
                    
                ])->grow(false),
            ]),
            TextColumn::make('users.name')
            ->searchable()
            ->badge()
            ->formatStateUsing(function (User $records, BadgeBoard $badge){

                $user = $records->where('id', '=', $badge->badge_owner)->first();

                return "Given to: {$user->name}";
            }),
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListBadgeBoards::route('/'),
            'edit' => Pages\EditBadgeBoard::route('/{record}/edit'),
        ];
    }
}
