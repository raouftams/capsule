<?php

namespace App\Filament\Resources\UserImages;

use App\Filament\Resources\UserImages\Pages\CreateUserImage;
use App\Filament\Resources\UserImages\Pages\EditUserImage;
use App\Filament\Resources\UserImages\Pages\ListUserImages;
use App\Filament\Resources\UserImages\Schemas\UserImageForm;
use App\Filament\Resources\UserImages\Tables\UserImagesTable;
use App\Models\UserImage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserImageResource extends Resource
{
    protected static ?string $model = UserImage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getModelLabel(): string
    {
        return __('filament.user_images.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.user_images.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.user_images.title');
    }

    public static function getBreadcrumb(): string
    {
        return __('filament.user_images.breadcrumb');
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function form(Schema $schema): Schema
    {
        return UserImageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserImagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserImages::route('/'),
            'create' => CreateUserImage::route('/create'),
            'edit' => EditUserImage::route('/{record}/edit'),
        ];
    }
}
