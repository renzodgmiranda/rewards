<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function checkPostUsers(array $users){
        if($users == ['all']){
            return User::all()->pluck('id');
        }
        else{
            return $users;
        }
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {

        $record->update([
            'post_title' => $data['post_title'],
            'post_body' => $data['post_body'],
            'post_image' => $data['post_image'],
            'post_users' => $this->checkPostUsers($data['post_users']),
        ]);

        return $record;
    }
}
