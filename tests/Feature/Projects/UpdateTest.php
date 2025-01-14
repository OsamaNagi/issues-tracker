<?php

it('can update a project', function () {
    login();

    $project = project();

    $this->patch(route('project.update', $project), [
        'name' => $project->name,
        'description' => $project->description,
        'visibility' => $project->visibility,
    ])->assertRedirect(route('projects.index', $project));

    $this->assertDatabaseHas('projects', $project->toArray());
});
