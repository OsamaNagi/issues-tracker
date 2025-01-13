<?php

use App\Models\Project;

it('show project response', function () {
    login();

    $project = Project::factory()->create();

    $response = $this->get('/projects/' . $project->id);

    $response->assertOk();
});
