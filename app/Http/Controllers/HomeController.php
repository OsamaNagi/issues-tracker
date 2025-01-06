<?php

namespace App\Http\Controllers;

use App\Models\Labels;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $publicProjects = Project::public()->count();
        $privateProjects = Project::private()->count();

        // Get the count of users with each role
        $roleCounts = User::with('roles')
            ->get()
            ->groupBy(fn($user) => $user->roles->first()->name ?? 'No Role')
            ->map(fn($group) => $group->count())
            ->toArray();

        $userRoles = array_keys($roleCounts);
        $series = array_values($roleCounts);

        // get the current user total issues count and the labels for the chart
        $userIssues = $user->issues()->count();
        $labels = Labels::all()->pluck('name')->toArray();

        return Inertia::render('Home', [
            'publicProjects' => $publicProjects,
            'privateProjects' => $privateProjects,
            'userRoles' => $userRoles,
            'series' => $series,
        ]);
    }
}
