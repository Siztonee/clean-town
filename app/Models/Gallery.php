<?php

namespace App\Models;

use App\Models\GalleryItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    protected $guarded = [];

    public function Items(): HasMany
    {
        return $this->hasMany(GalleryItem::class);
    }
}
