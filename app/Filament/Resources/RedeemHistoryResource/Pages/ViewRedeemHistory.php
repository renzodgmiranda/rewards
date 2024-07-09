<?php

namespace App\Filament\Resources\RedeemHistoryResource\Pages;

use App\Filament\Resources\RedeemHistoryResource;
use App\Models\RedeemHistory;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewRedeemHistory extends ViewRecord
{
    protected static string $resource = RedeemHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
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
                ->action(fn(RedeemHistory $record, $data) => $record->changeStatus($data, $record)),
        ];
    }
}
