<?php
namespace App\Services\Admin;

use App\Models\History;

class HistoryService
{
    public function createHistory(array $data): History
    {
        return History::create($data);
    }

    public function updateHistory(History $history, array $data): bool
    {   
        return $history->update($data);
    }

    public function deleteHistory(History $history): bool
    {
        return $history->delete();
    }
}