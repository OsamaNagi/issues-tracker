<?php

it('can change project status to closed', function () {
    login();

    $project = project();

    $this->patch(route('project.close', $project))
        ->assertRedirect(route('project.edit', $project));

    $this->assertDatabaseHas('projects', ['id' => $project->id, 'status' => 'closed']);
});
