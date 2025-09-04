<?php

namespace App\Filament\Pages;

use App\Models\Favorite;
use App\Models\UserImage;
use App\Services\ArtInstituteService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Favorites extends Page
{
    use WithPagination;
    protected string $view = 'filament.pages.favorites';

    public int $perPage = 12;
    public ?string $search = null;

    protected $queryString = ['search', 'page'];

    public function getTitle(): string
    {
        return __('filament.favorites.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.favorites.title');
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-heart';
    }

    public function getFavorites(): LengthAwarePaginator
    {
        $userId = Auth::id();

        $apiFavorites = Favorite::query()
            ->where('user_id', $userId)
            ->where('imageable_type', 'api')
            ->get()
            ->map(fn($fav) => [
                'id' => $fav->imageable_id,
                'title' => json_decode($fav->metadata, true)['title'] ?? '',
                'url' => json_decode($fav->metadata, true)['image_url'] ?? null,
                'favorite_id' => $fav->id,
                'valid' => true,
            ]);

        $userFavorites = Favorite::query()
            ->where('user_id', $userId)
            ->where('imageable_type', UserImage::class)
            ->with('imageable')
            ->get()
            ->map(fn($fav) => [
                'id' => $fav->imageable?->id,
                'title' => $fav->imageable?->title ?? __('filament.favorites.deleted_image'),
                'url' => $fav->imageable?->image_path ? Storage::url($fav->imageable->image_path) : null,
                'favorite_id' => $fav->id,
                'valid' => (bool) $fav->imageable,
            ]);

        $records = collect($apiFavorites)->merge(collect($userFavorites));

        if ($this->search) {
            $records = $records->filter(fn($item) => stripos($item['title'], $this->search) !== false);
        }

        $page = Paginator::resolveCurrentPage('page');
        $total = $records->count();
        $items = $records->forPage($page, $this->perPage);

        return new LengthAwarePaginator(
            $items,
            $total,
            $this->perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    public function toggleFavorite($favoriteId)
    {
        $existing = Auth()->user()->favorites()->where('id', $favoriteId)->first();
        if ($existing) {
            $existing->delete();
            // Show success notification
            Notification::make()
                ->title(__('filament.favorites.removed'))
                ->success()
                ->send();
        }
        $this->dispatch('refresh');
    }

    public function downloadImage($url, $filename)
    {
        $content = Http::get($url)->body();
        return response()->streamDownload(
            fn() => print ($content),
            $filename . '.jpg'
        );
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
