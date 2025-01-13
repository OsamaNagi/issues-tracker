<?php

use App\Models\Project;

it('can create a project', function () {
    login();

    $project = Project::factory()->create();

    $this->assertDatabaseHas('projects', $project->toArray());
});
