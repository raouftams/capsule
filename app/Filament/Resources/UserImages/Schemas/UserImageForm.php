<?php

namespace App\Filament\Resources\UserImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UserImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(__('filament.user_images.form.title'))
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('description')
                    ->label(__('filament.user_images.form.description'))
                    ->columnSpanFull(),
                FileUpload::make('image_path')
                    ->image()
                    ->label(__('filament.user_images.upload.label'))
                    ->disk('public')
                    ->directory('user-images')
                    ->maxSize(6144) // 6 MB
                    ->required(),
            ]);
    }
}
