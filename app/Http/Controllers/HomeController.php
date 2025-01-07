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

        $publicProjects = Project::query()->public()->count();
        $privateProjects = Project::query()->private()->count();

        // Get the count of users with each role
        $roleCounts = User::with('roles')
            ->get()
            ->groupBy(fn($user) => $user->roles->first()->name ?? 'No Role')
            ->map(fn($group) => $group->count())
            ->toArray();

        $userRoles = array_keys($roleCounts);
        $series = array_values($roleCounts);

        // Count all user issues
        $userIssuesCount = $user->issues()->count();

        // get all user issues with their priority
        $userIssuesPriority = $user->issues
            ->groupBy('priority')
            ->map(fn($group) => [
                'name' => $group->first()->priority,
                'count' => $group->count(),
            ])
            ->values();

        // Get labels associated with the user's issues
        $userIssueLabels = $user->issues()
            ->with('labels') // Assuming 'labels' is the relationship on the Issue model
            ->get()
            ->pluck('labels') // Extract labels collection
            ->flatten() // Flatten nested label collections
            ->unique('id') // Remove duplicates based on label ID
            ->map(function ($label) {
                return [
                    'name' => $label->name,
                    'color' => $label->color,
                    'count' => $label->issues->count(),
                ];
            })->values();

        return Inertia::render('Home', [
            'publicProjects' => $publicProjects,
            'privateProjects' => $privateProjects,
            'userRoles' => $userRoles,
            'series' => $series,
            'userIssuesCount' => $userIssuesCount,
            'userIssueLabels' => $userIssueLabels,
            'userIssuesPriority' => $userIssuesPriority,
        ]);
    }
}
