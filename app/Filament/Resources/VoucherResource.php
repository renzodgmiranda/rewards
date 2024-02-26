<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoucherResource\Pages;
use App\Filament\Resources\VoucherResource\RelationManagers;
use App\Models\Voucher;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class VoucherResource extends Resource
{
    protected static ?string $model = Voucher::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('voucher_code')->label('Voucher Code'),
                TextInput::make('voucher_points')->label('Voucher Points')
                ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                if($user->hasRole('Employee')) {
                    $query->where('claimed_by', $user->name);
                }

                return $query;
            })
            ->columns([
                TextColumn::make('voucher_code')->label('Voucher Code'),
                TextColumn::make('voucher_points')->label('Voucher Points'),
                TextColumn::make('claimed_by')->label('Claimed by')
                ->visible(function () {
                    $user = Auth::user();

                    if($user->hasAnyRole(['Admin'])) {
                        return true;
                    }

                    return false;
                }),
                TextColumn::make('claimed')->label('Claimed')
                ->formatStateUsing(fn (string $state): string => $state === '0' ? __('No') : __('Yes'))
                ->visible(function () {
                    $user = Auth::user();

                    if($user->hasAnyRole(['Admin'])) {
                        return true;
                    }

                    return false;
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListVouchers::route('/'),
            'create' => Pages\CreateVoucher::route('/create'),
            'edit' => Pages\EditVoucher::route('/{record}/edit'),
        ];
    }
}
