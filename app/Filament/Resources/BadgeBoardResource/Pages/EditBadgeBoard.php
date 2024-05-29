<?php

namespace App\Filament\Resources\BadgeBoardResource\Pages;

use App\Filament\Resources\BadgeBoardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBadgeBoard extends EditRecord
{
    protected static string $resource = BadgeBoardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
