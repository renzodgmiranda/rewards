<?php

namespace App\Filament\Pages\Auth;

use App\Models\PointHistory;
use App\Models\User;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\RegistrationResponse;
use Filament\Pages\Auth\Register as Register;
use Illuminate\Support\Facades\Auth;

class Registration extends Register
{


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    public function register(): ?RegistrationResponse
    {
        $return = parent::register();
        Auth::user()->assignRole('Employee');
        $this->createPointRecords(Auth::user());
        return $return;
    }

    protected function createPointRecords(User $user)
    {
        if(PointHistory::where('user_id', $user->id)->exists())
        {
            return ;

        }

        else{
            return PointHistory::create([
                'user_id' => $user->id,
                'log_user' => $user->name,
                'log_content' => [],
            ]);
        }

    }
}
