<?php

it('shows the edit project page', function () {
    // login the user using the login helper
    login();

    // create a project using the project helper
    $project = project();

    // visit the edit project page
    $this->get(route('project.edit', $project))
        ->assertOk()
        ->assertSee($project->name)
        ->assertSee($project->description)
        ->assertSee($project->visibility);
});
