<?php

namespace App\Observers;

use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;

class TeamMemberObserver
{
    /**
     * Handle the TeamMember "updated" event.
     */
    public function updated(TeamMember $teamMember): void
    {
        if ($teamMember->isDirty('profile') && $teamMember->getOriginal('profile')) {
            $oldProfile = parse_url($teamMember->getOriginal('profile'), PHP_URL_PATH);
            $oldProfile = str_replace('/storage/', '', $oldProfile);
            Storage::disk('public')->delete($oldProfile);
        }
    }

    /**
     * Handle the TeamMember "deleted" event.
     */
    public function deleted(TeamMember $teamMember): void
    {
        if ($teamMember->profile) {
            $profilePath = parse_url($teamMember->profile, PHP_URL_PATH);
            $profilePath = str_replace('/storage/', '', $profilePath);
            Storage::disk('public')->delete($profilePath);
        }
    }
}
