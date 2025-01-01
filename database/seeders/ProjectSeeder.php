<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project1 = Project::create([
            'name' => 'Project Alpha',
            'description' => 'This is a project description.',
            'user_id' => 1,
            'status' => 'open',
            'visibility' => 'public',
        ]);
        $project2 = Project::create([
            'name' => 'Project Beta',
            'description' => 'This is a project description.',
            'user_id' => 1,
            'status' => 'closed',
            'visibility' => 'private',
        ]);

        // Assign users to projects
        $project1->users()->attach(User::where('email', 'admin@example.com')->first());
        $project2->users()->attach(User::where('email', 'manager@example.com')->first());
    }
}
