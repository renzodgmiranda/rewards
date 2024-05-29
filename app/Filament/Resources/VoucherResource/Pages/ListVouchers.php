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
            ->visible(function () {
                $user = Auth::user();

                if($user->hasAnyRole(['Employee'])) {
                    return true;
                }

                return false;
            })
            ->action(function(array $data){

                $user = Auth::user();
                $code = $data['voucher'];
                $voucher = Voucher::where('voucher_code', $code)->first();

                $q1Pts = $user->q1_points;
                $q2Pts = $user->q2_points;
                $q3Pts = $user->q3_points;
                $q4Pts = $user->q4_points;
                
                
                if($voucher){

                    if($voucher->claimed === 1){
                        Notification::make()
                            ->title("Voucher Code has already been Claimed")
                            ->danger()
                            ->send();
                    }

                    else{

                    $q1 = 0;
                    $q2 = 0;
                    $q3 = 0;
                    $q4 = 0;

                    $m = date('m');

                    if($m >= 1 && $m <= 3){
                        $q1 += $voucher->voucher_points;
                    }
                    if($m >= 4 && $m <= 6){
                        $q2 += $voucher->voucher_points;
                    }
                    if($m >= 7 && $m <= 9){
                        $q3 += $voucher->voucher_points;
                    }
                    if($m >= 10 && $m <= 12){
                        $q4 += $voucher->voucher_points;
                    }

                        $user->update([
                            'points' => $user->points + $voucher->voucher_points,
                            'q1_points' => $q1Pts + $q1,
                            'q2_points' => $q2Pts + $q2,
                            'q3_points' => $q3Pts + $q3,
                            'q4_points' => $q4Pts + $q4,
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
