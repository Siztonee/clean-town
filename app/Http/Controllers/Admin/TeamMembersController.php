<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TeamMembersService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TeamMemberStoreRequest;
use App\Http\Requests\TeamMemberUpdateRequest;

class TeamMembersController extends Controller
{
    public function __construct(
        private TeamMembersService $teamMemberService
    ) {}

    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/TeamMembers', [
            'teamMembers' => TeamMember::all()
        ]);
    }

    public function store(TeamMemberStoreRequest $request): RedirectResponse 
    {
        $validated = $request->validated();
        $this->teamMemberService->createTeamMember($validated, $request->file('profile'));

        return back();
    }
    
    public function update(TeamMember $teamMember, TeamMemberUpdateRequest $request): RedirectResponse 
    {
        $validated = $request->validated();
        $this->teamMemberService->updateTeamMember($teamMember, $validated, $request->file('profile'));

        return back();
    }
        
    public function destroy(TeamMember $teamMember): RedirectResponse 
    {
        $this->teamMemberService->deleteTeamMember($teamMember);
        return back();
    }
}
