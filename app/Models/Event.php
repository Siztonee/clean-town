<?php

namespace App\Models;

use App\Models\EventMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $guarded = [];

    public function members(): HasMany
    {
        return $this->hasMany(EventMember::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    protected $appends = ['image_url'];
}
