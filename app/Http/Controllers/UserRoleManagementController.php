<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserRoleManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        return Inertia::render('UserRoleManagement', [
            'users' => $users,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);
        return redirect()->route('user-role-management.index');
    }
}
