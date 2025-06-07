<?php

namespace App\Models;

use App\Models\GalleryItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    protected $guarded = [];

    public function items(): HasMany
    {
        return $this->hasMany(GalleryItem::class);
    }

    public function getPreviewUrlAttribute()
    {
        return $this->preview ? Storage::disk('public')->url($this->preview) : null;
    }

    protected $appends = ['preview_url'];
}
