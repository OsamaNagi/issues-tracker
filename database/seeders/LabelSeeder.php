<?php

namespace Database\Seeders;

use App\Models\Labels;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labels = [
            ['name' => 'bug', 'color' => '#DC2626'],
            ['name' => 'question', 'color' => '#DB2777'],
            ['name' => 'documentation', 'color' => '#2563EB'],
            ['name' => 'duplicate', 'color' => '#E2E8F0'],
            ['name' => 'enhancement', 'color' => '#99F6E4'],
            ['name' => 'good first issue', 'color' => '#6366F1'],
            ['name' => 'help wanted', 'color' => '#14B8A6'],
            ['name' => 'invalid', 'color' => '#FDE047'],
            ['name' => 'wontfix', 'color' => '#F8FAFC']
        ];

        foreach ($labels as $label) {
            Labels::create($label);
        }
    }
}
