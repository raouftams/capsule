<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class UserImage extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'image_path'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'imageable');
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }

    public function isFavorited(): bool
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }
}
