<?php

namespace Database\Seeders;

use App\Models\Issue;
use App\Models\Labels;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labels = Labels::all();

        Issue::factory(20)->create()->each(function ($issue) use ($labels) {
            $issue->labels()->attach($labels->random());
        });
    }
}
