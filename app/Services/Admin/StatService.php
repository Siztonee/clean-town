<?php
namespace App\Services\Admin;

use App\Models\Stat;

class StatService
{
    public function createStat(array $data): Stat
    {
        return Stat::create($data);
    }

    public function updateStat(Stat $stat, array $data): bool
    {   
        return $stat->update($data);
    }

    public function deleteStat(Stat $stat): bool
    {
        return $stat->delete();
    }
}