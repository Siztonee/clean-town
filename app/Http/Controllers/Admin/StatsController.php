<?php

namespace App\Http\Controllers\Admin;

use App\Models\Stat;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\StatService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StatStoreRequest;
use App\Http\Requests\StatUpdateRequest;

class StatsController extends Controller
{
    public function __construct(
        private StatService $statService
    ) {}

    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/Stats', [
            'stats' => Stat::all()
        ]);
    }

    public function store(StatStoreRequest $request): RedirectResponse 
    {
        $validated = $request->validated();
        $this->statService->createStat($validated);

        return back();
    }
    
    public function update($stat_id, StatUpdateRequest $request): RedirectResponse 
    {
        $stat = Stat::findOrFail($stat_id);
        $validated = $request->validated();
        $this->statService->updateStat($stat, $validated);

        return back();
    }
        
    public function destroy($stat_id): RedirectResponse 
    {
        $stat = Stat::findOrFail($stat_id);
        $this->statService->deleteStat($stat);
        return back();
    }
}
