<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'imageable_id', 'imageable_type', 'metadata'];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
