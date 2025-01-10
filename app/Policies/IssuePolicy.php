<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;

class IssuePolicy
{
    /**
     * Create a new policy instance.
     */
    public function edit(User $user, Issue $issue): bool
    {
        // check if the user is admin or the creator of the issue he can edit the issue
        return $user->hasRole('admin') || $issue->created_by === $user->id;
    }
}
