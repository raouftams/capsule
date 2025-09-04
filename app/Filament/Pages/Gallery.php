<?php

namespace App\Filament\Pages;

use App\Models\Favorite;
use App\Services\ArtInstituteService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\WithPagination;

class Gallery extends Page
{
    use WithPagination;

    protected string $view = 'filament.pages.gallery';

    public $search = '';
    public $perPage = 12;
    public $images = [];
    public $pagination = [];

    protected $listeners = ['refresh' => '$refresh'];

    public function getTitle(): string
    {
        return __('filament.gallery.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.gallery.title');
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-photo';
    }

    public function mount()
    {
        $this->loadImages();
    }

    public function loadImages()
    {
        $service = new ArtInstituteService();
        $result = $service->fetchImages($this->getPage(), $this->perPage, $this->search);
        $this->images = $result['images'];
        $this->pagination = $result['pagination'];
    }

    public function updatedSearch()
    {
        $this->pagination['current_page'] = 1;
        $this->loadImages();
    }

    public function toggleFavorite($imageJson)
    {
        try {
            $imageData = json_decode($imageJson, true);
            // Check if already favorited
            $existingFavorite = auth()->user()->favorites()
                ->where('imageable_id', $imageData['id'])
                ->where('imageable_type', $imageData['source'])
                ->first();

            if ($existingFavorite) {
                $existingFavorite->delete();
                Notification::make()
                    ->title(__('filament.favorites.removed'))
                    ->success()
                    ->send();
            } else {
                Favorite::create([
                    'user_id' => auth()->id(),
                    'imageable_id' => $imageData['id'],
                    'imageable_type' => $imageData['source'],
                    'metadata' => json_encode([
                        'title' => $imageData['title'] ?? '',
                        'description' => $imageData['description'] ?? '',
                        'image_url' => $imageData['url'] ?? '',
                    ]),
                ]);
                // Show success notification
                Notification::make()
                    ->title(__('filament.favorites.added'))
                    ->success()
                    ->send();
            }

            $this->dispatch('refresh');
        } catch (\Exception $e) {
            // log the error for
            \Log::error('Error toggling favorite: ' . $e->getMessage());
            // send notification
            Notification::make()
                ->title(__('filament.favorites.error'))
                ->danger()
                ->send();
        }
    }

    public function downloadImage($imageUrl, $title)
    {
        $filename = strtolower(str_replace(' ', '-', $title)) . '.jpg';

        return response()->streamDownload(function () use ($imageUrl) {
            echo file_get_contents($imageUrl);
        }, $filename, [
            'Content-Type' => 'image/jpeg',
        ]);
    }

    public function updatedPerPage()
    {
        $this->loadImages();
    }

    protected function getPage()
    {
        return $this->pagination['current_page'] ?? 1;
    }

    public function previousPage()
    {
        if ($this->getPage() > 1) {
            $this->pagination['current_page'] = $this->getPage() - 1;
            $this->loadImages();
        }
    }

    public function nextPage()
    {
        if ($this->getPage() < ($this->pagination['total_pages'] ?? 1)) {
            $this->pagination['current_page'] = $this->getPage() + 1;
            $this->loadImages();
        }
    }

    public function gotoPage($page)
    {
        if ($page <= $this->pagination['total_pages']) {
            $this->pagination['current_page'] = $page;
            $this->loadImages();
        }
    }
}
