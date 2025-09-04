<?php

namespace App\Filament\Resources\UserImages\Pages;

use App\Filament\Resources\UserImages\UserImageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserImage extends EditRecord
{
    protected static string $resource = UserImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
