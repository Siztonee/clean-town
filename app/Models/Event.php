<?php

namespace App\Models;

use App\Models\User;
use App\Models\EventMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    protected $guarded = [];

    public function members(): HasMany
    {
        return $this->hasMany(EventMember::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_members', 'event_id', 'user_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    protected $appends = ['image_url'];
}
