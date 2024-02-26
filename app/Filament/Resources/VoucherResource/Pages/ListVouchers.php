<?php

namespace App\Filament\Resources\VoucherResource\Pages;

use App\Filament\Imports\VoucherImporter;
use App\Filament\Resources\VoucherResource;
use App\Models\User;
use App\Models\Voucher;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListVouchers extends ListRecords
{
    protected static string $resource = VoucherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add New Voucher'),
            ImportAction::make()
                ->visible(function () {
                    $user = Auth::user();

                    if($user->hasAnyRole(['Admin'])) {
                        return true;
                    }

                    return false;
                })
                ->importer(VoucherImporter::class),
            Actions\Action::make('Redeem')->label('Redeem Voucher Code')
            ->form([
                TextInput::make('voucher')->label('Voucher Code')
            ])
            ->action(function(array $data){

                $user = Auth::user();
                $code = $data['voucher'];
                $voucher = Voucher::where('voucher_code', $code)->first();
                
                if($voucher){

                    if($voucher->claimed === 1){
                        Notification::make()
                            ->title("Voucher Code has already been Claimed")
                            ->danger()
                            ->send();
                    }

                    else{
                        $user->update([
                            'points' => $user->points + $voucher->voucher_points
                        ]);
    
                        $voucher->update([
                            'claimed_by' => $user->name,
                            'claimed' => true,
                        ]);

                        Notification::make()
                            ->title("Voucher Code Successfully Claimed")
                            ->success()
                            ->send();
                    }
                    
                }

                else{
                    Notification::make()
                            ->title("Voucher Code is invalid")
                            ->danger()
                            ->send();
                }

            }),
        ];
    }
}
