<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserRoleManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);

        $roles = Role::all();

        return Inertia::render('UserRoleManagement', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|exists:roles,id', // Ensure the role exists in the roles table
        ]);

        $user->roles()->sync([$validated['role']]);

        return redirect()->route('user-role-management');
    }
}
