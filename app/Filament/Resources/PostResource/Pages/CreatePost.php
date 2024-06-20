<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create([
            'post_owner' => $data['post_owner'],
            'post_title' => $data['post_title'],
            'post_body' => $data['post_image'],
            'post_users' => $data['users'],
            'user_id' => auth()->user()->id
        ]);
    }
}
