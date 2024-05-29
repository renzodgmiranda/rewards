<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseProfileSettings;

class ProfileSettings extends BaseProfileSettings
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent()->disabled(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
