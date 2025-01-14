<?php

use App\Models\Issue;
use App\Models\Project;

it('show project response', function () {
    login();

    $project = Project::factory()->create();
    $issues = Issue::factory()->count(3)->create(['project_id' => $project->id]);

    $response = $this->get(route('project.show', $project));

    $response->assertStatus(200);

    foreach ($issues as $issue) {
        $response->assertSee($issue->title);
    }
});
