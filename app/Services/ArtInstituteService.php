<?php

namespace App\Services;

use Cache;
use Illuminate\Support\Facades\Http;

class ArtInstituteService
{
    protected string $baseUrl = 'https://api.artic.edu/api/v1/artworks';

    public function fetchImages(int $page = 1, int $limit = 12, ?string $search = null): array
    {
        $isLivewireRequest = request()->header('X-Livewire') || request()->ajax();
        $salt = !$isLivewireRequest ? uniqid('reload_', true) : '';
        $cacheKey = "artworks_{$search}_page_{$page}_limit_{$limit}_{$salt}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($page, $limit, $search) {
            $query = [
                'page' => $page,
                'limit' => $limit * 1.5, // overfetch to have enough after skipping
                'fields' => 'id,title,image_id',
            ];

            $url = $this->baseUrl;
            if ($search) {
                $query['q'] = $search;
                $url .= '/search';
            }

            $response = Http::timeout(15)->get($url, $query);

            if (!$response->successful()) {
                return [
                    'images' => [],
                    'pagination' => [
                        'current_page' => $page,
                        'per_page' => $limit,
                        'total' => 0,
                        'total_pages' => 0,
                    ],
                ];
            }

            $data = $response->json();
            $images = [];

            foreach ($data['data'] as $artwork) {
                $url = $this->buildImageUrl($artwork['image_id'] ?? null);
                if (!$url) {
                    continue; // skip missing images
                }

                $images[] = [
                    'id' => $artwork['id'],
                    'title' => addslashes($artwork['title']) ?? 'Untitled', // adding slashes to avoid JSON issues
                    'image_id' => $artwork['image_id'] ?? $artwork['id'],
                    'url' => $url,
                    'source' => 'api',
                ];
            }

            // Randomize & take only needed limit
            $images = collect($images)->take($limit)->values()->toArray();

            return [
                'images' => $images,
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $limit,
                    'total' => $data['pagination']['total'] ?? count($images),
                    'total_pages' => $data['pagination']['total_pages'] ?? $page,
                ],
            ];
        });
    }


    public function buildImageUrl(?string $imageId): ?string
    {
        if (!$imageId)
            return null;
        return "https://www.artic.edu/iiif/2/{$imageId}/full/843,/0/default.jpg";
    }
}