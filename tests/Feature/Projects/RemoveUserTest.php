<?php

use App\Models\User;

it('can remove user from project', function () {
    login();

    $project = project();
    $user = User::factory()->create();

    $project->users()->attach($user);

    $this->delete(route('project.removeUser', [$project, $user]))
        ->assertRedirect(route('project.ShowProjectUsers', $project));

    $this->assertDatabaseMissing('project_user', ['project_id' => $project->id, 'user_id' => $user->id]);
});
