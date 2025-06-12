<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Admin\HistoryService;
use App\Http\Requests\HistoryStoreRequest;
use App\Http\Requests\HistoryUpdateRequest;

class HistoryBoardController extends Controller
{
    public function __construct(
        private HistoryService $historyService
    ) {}

    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/History', [
            'histories' => History::all()
        ]);
    }

    public function store(HistoryStoreRequest $request): RedirectResponse 
    {
        $validated = $request->validated();
        $this->historyService->createHistory($validated);

        return back();
    }
    
    public function update($history_id, HistoryUpdateRequest $request): RedirectResponse 
    {
        $history = History::findOrFail($history_id);
        $validated = $request->validated();
        $this->historyService->updateHistory($history, $validated);

        return back();
    }
        
    public function destroy($history_id): RedirectResponse 
    {
        $history = History::findOrFail($history_id);
        $this->historyService->deleteHistory($history);
        return back();
    }
}
