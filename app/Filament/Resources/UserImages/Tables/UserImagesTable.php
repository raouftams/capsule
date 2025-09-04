<?php

namespace App\Filament\Resources\UserImages\Tables;

use App\Models\Favorite;
use App\Models\UserImage;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class UserImagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label(__('filament.user_images.table.image'))
                    ->disk('public')
                    ->square(),

                TextColumn::make('title')
                    ->label(__('filament.user_images.table.title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label(__('filament.user_images.table.description'))
                    ->limit(50)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('filament.user_images.table.uploaded_at'))
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Action::make('view')
                    ->label('')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn($record) => $record->title)
                    ->modalContent(fn($record) => new HtmlString(
                        '<div class="space-y-4">
                            <img src="' . e(Storage::url($record->image_path)) . '" 
                                 alt="' . e($record->title) . '" 
                                 class="rounded-lg shadow max-h-96 mx-auto">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">' . e($record->description) . '</p>
                        </div>'
                    ))
                    ->modalWidth('2xl')
                    ->modalSubmitAction(false),
                    
                EditAction::make()->label(''),
                DeleteAction::make()->label(''),

                Action::make('download')
                    ->label('')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record, $livewire) {
                        $path = $record->image_path;

                        if (!$path || !Storage::disk('public')->exists($path)) {
                            $livewire->notify('danger', 'File not found.');
                            return;
                        }
                        return response()->streamDownload(function () use ($path) {
                            echo Storage::disk('public')->get($path);
                        }, basename($path));
                    }),

                Action::make('favorite')
                    ->label('')
                    ->icon('heroicon-o-heart')
                    ->color(fn($record) => $record->isFavorited() ? 'danger' : 'secondary')
                    ->action(function ($record) {
                        $user = Auth::user();

                        $exists = Favorite::where([
                            'user_id' => $user->id,
                            'imageable_id' => $record->id,
                            'imageable_type' => UserImage::class,
                        ])->exists();

                        if (!$exists) {
                            Favorite::create([
                                'user_id' => $user->id,
                                'imageable_id' => $record->id,
                                'imageable_type' => UserImage::class,
                            ]);
                            // Show success notification
                            Notification::make()
                                ->title(__('filament.favorites.added'))
                                ->success()
                                ->send();
                        }
                    }),
            ])
            ->actionsColumnLabel(__('filament.user_images.table.actions'))
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
