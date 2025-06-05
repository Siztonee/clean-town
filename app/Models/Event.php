<?php

namespace App\Models;

use App\Models\EventMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $guarded = [];

    public function Members(): HasMany
    {
        return $this->hasMany(EventMember::class);
    }
}
