<?php

namespace App\Filament\Pages\Auth;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Pages\Auth\EditProfile as BaseProfileSettings;
use LaraZeus\Popover\Infolists\PopoverEntry;
use LaraZeus\Qr\Facades\Qr;

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
                \LaraZeus\Popover\Form\PopoverForm::make('points')
                    ->label("Your Points (Click it to show QR to add more)")
                    ->trigger('click') // support click and hover
                    ->placement('bottom') // for more: https://alpinejs.dev/plugins/anchor#positioning
                    ->popOverMaxWidth('none')
                    ->content(\LaraZeus\Qr\Facades\Qr::render(data: UserResource::getUrl('addPts', ['record' => auth()->user()])))

                //Qr::render(statePath: static::getUrl(panel: 'edit', tenant: $this->record())),
            ]);
    }
}
