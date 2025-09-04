<?php

namespace App\Filament\Resources\UserImages\Pages;

use App\Filament\Resources\UserImages\UserImageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserImage extends CreateRecord
{
    protected static string $resource = UserImageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    public function getTitle(): string
    {
        return __('filament.user_images.create.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.user_images.title');
    }


}
