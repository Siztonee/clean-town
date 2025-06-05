<?php

namespace App\Models;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryItem extends Model
{
    protected $guarded = [];

    public function Gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }
}
