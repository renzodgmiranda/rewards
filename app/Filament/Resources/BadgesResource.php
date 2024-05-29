<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BadgesResource\Pages;
use App\Filament\Resources\BadgesResource\RelationManagers;
use App\Models\BadgeBoard;
use App\Models\Badges;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BadgesResource extends Resource
{
    protected static ?string $model = Badges::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Admin';

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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button(),
                Action::make('Give Badge To')
                    ->button()
                    ->form([
                        Repeater::make('Assign')->schema([
                            Select::make('givenTo')
                            ->label('Give to:')
                            ->options(User::role('Employee')->get()->pluck('name', 'id'))
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                        ])
                    ])
                    ->action(function ($data, Badges $badge, BadgeBoard $post){

                        $assignList = $data['Assign'] ?? [];
                        $idAssigned = collect($assignList)->pluck('givenTo');
                        $count = $idAssigned->count();
                        $name = $badge->badge_name;
                        $image = $badge->badge_image;

                        for ($i = 0; $count > $i; $i++){
                            $id = $idAssigned->get($i);

                            $post->create([
                                'badge_name' => $name,
                                'badge_image' => $image,
                                'badge_owner' => $id,
                            ]);

                        }

                    }),
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
            'index' => Pages\ListBadges::route('/'),
            'create' => Pages\CreateBadges::route('/create'),
            'edit' => Pages\EditBadges::route('/{record}/edit'),
        ];
    }
}
