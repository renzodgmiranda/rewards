<?php

namespace App\Livewire;

use App\Models\RedeemHistory;
use App\Models\Rewards;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class ConfirmModal extends ModalComponent
{
    public Rewards $rewards;

    public array $data;

    public $note = '';

    public $quantity = 0;

    public function increment()
    {
        $this->quantity++;
    }

    public function decrement()
    {
        if ($this->quantity > 0) {
            $this->quantity--;
        }
    }

    public function save()
    {
        $this->data = ['quantity' => $this->quantity, 'note' => $this->note];

        $this->redeem($this->rewards, $this->data);

        return $this->redirect('/rewards');
    }

    public function render()
    {
        return view('livewire.confirm-modal');
    }

    public function redeem($reward, $data){

        $user = Auth::user();

        $cost = $reward->rewards_points * $data['quantity'];
        $totalPts = $user->points;

        if($user->points >= $cost && $reward->rewards_quantity >= $data['quantity']){

            $user->update([
                'points' => $totalPts - $cost,
                'used_points' => $user->used_points + $cost,
            ]);

            $quantity = $reward->rewards_quantity;
            $value = $quantity - $data['quantity'];

            $reward->update([
                'rewards_quantity' => $value
            ]);

            RedeemHistory::create([
                'user_id' => $user->id,
                'rewards_id' => $reward->id,
                'redeemed_name' => $reward->rewards_name,
                'redeemed_image' => $reward->rewards_image,
                'redeemed_points' => $cost,
                'redeemed_quantity' => $data['quantity'],
                'redeemed_status' => 'Processing',
                'redeemed_by' => $user->name,
                'redeemed_user_note' => $data['note'],
                'expiry' => 1,
            ]);

            Notification::make()
                ->title(fn (Rewards $record): string => __("Successfully Redeemed {$record->rewards_name}"))
                ->success()
                ->send();

            //Mail::to($vendor->email)->send(new WorkorderAssigned($workorder));
        }

        elseif($user->points < $cost){
            Notification::make()
            ->title(fn (): string => __("Insuffcient Points"))
            ->danger()
            ->send();
        }

        elseif($reward->rewards_quantity < $data['quantity']){
            Notification::make()
            ->title(fn (): string => __("Quantity given is higher than Stock"))
            ->danger()
            ->send();
        }



    }

}
