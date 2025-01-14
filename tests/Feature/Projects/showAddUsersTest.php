<?php

use App\Models\User;

it('shows the add users to a project page with users', function () {
    login();

    $project = project();
    $users = User::factory()->count(3)->create();
    $project->users()->attach($users);

    $response = $this->get(route('project.ShowProjectUsers', $project))->assertOk();

    foreach ($users as $user) {
        $response->assertSee($user->name);
    }
});
