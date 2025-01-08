<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    public function edit(User $user, Project $project): bool
    {
        // check if the user is admin or project manager he can edit the project
        return $user->hasRole('admin') || $project->user_id === $user->id;
    }

    public function delete(User $user, Project $project): bool
    {
        // check if the user is admin or project manager he can delete the project
        return $user->hasRole('admin') || $project->user_id === $user->id;
    }

    public function add(User $user, Project $project): bool
    {
        // check if the user is admin or project manager he can add user to the project
        return $user->hasRole('admin') || $project->user_id === $user->id;
    }
}
