<?php

it('can delete a project', function () {
    login();

    $project = project();

    $this->delete(route('project.destroy', $project))
        ->assertRedirect(route('projects.index'));

    $this->assertDatabaseMissing('projects', ['id' => $project->id]);
});
