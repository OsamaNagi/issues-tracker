<?php

use App\Models\Issue;
use App\Models\Project;

it('show project response', function () {
    login();

    $project = Project::factory()->create();
    $issues = Issue::factory()->count(3)->create(['project_id' => $project->id, 'created_by' => Auth::id()]);

    $response = $this->get(route('project.show', $project))->assertOk();

    foreach ($issues as $issue) {
        $response->assertSee($issue->title);
    }
});
