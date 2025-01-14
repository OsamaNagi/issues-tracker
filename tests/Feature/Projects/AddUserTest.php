<?php

use App\Models\User;

it('can add user to project', function () {
    login();

    $project = project();
    $user = User::factory()->create();

    $this->post(route('project.add-users', $project), ['user_ids' => [$user->id]])
        ->assertRedirect(route('project.ShowProjectUsers', $project));

    $this->assertDatabaseHas('project_user', ['project_id' => $project->id, 'user_id' => $user->id]);

    $this->get(route('project.ShowProjectUsers', $project))
        ->assertSee($user->name);
});
