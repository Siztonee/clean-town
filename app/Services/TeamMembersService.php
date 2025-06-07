<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Models\TeamMember;

class TeamMembersService
{
    protected function storeImage(UploadedFile $image): string
    {
        return $image->store('profiles', 'public');
    }

    public function createTeamMember(array $data, ?UploadedFile $image = null): TeamMember
    {
        if (!$image) {
            return abort(403);
        }

        $data['profile'] = $this->storeImage($image);

        return TeamMember::create($data);
    }

    public function updateTeamMember(TeamMember $teamMember, array $data, ?UploadedFile $image = null): bool
    {
        if ($image) {
            $data['profile'] = $this->storeImage($image);
        }

        return $teamMember->update($data);
    }

    public function deleteTeamMember(TeamMember $teamMember): bool
    {
        return $teamMember->delete();
    }
}