<?php

namespace Database\Seeders;

use App\Models\Stat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InitialStatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stats = [
            [
                'label' => 'Проведенных мероприятий',
                'number' => 128,
                'icon' => 'fa-calendar',                
            ],
            [
                'label' => 'Участников',
                'number' => 5200,
                'icon' => 'fa-users',                
            ],
            [
                'label' => 'Тонн мусора собрано',
                'number' => 42,
                'icon' => 'fa-trash',                
            ],
            [
                'label' => 'Районов охвачено',
                'number' => 18,
                'icon' => 'fa-map',                
            ],
        ];

        foreach ($stats as $stat) {
            Stat::firstOrCreate(
                ['label' => $stat['label']], $stat
            );
        }
    }
}
