<?php

namespace App\Filament\Resources\UserImages\Pages;

use App\Filament\Resources\UserImages\UserImageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserImages extends ListRecords
{
    protected static string $resource = UserImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
