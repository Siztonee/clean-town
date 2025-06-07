<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TeamMember extends Model
{
    protected $guarded = [];

    public function getProfileUrlAttribute()
    {
        return $this->profile ? Storage::disk('public')->url($this->profile) : null;
    }

    protected $appends = ['profile_url'];
}
