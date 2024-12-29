<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $projects = Project::with('creator')
            ->where('user_id', $user->id)
            ->orWhereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        return Inertia::render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'projects' => $projects,
        ]);
    }

    public function create()
    {
        return Inertia::render('Project/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'visibility' => 'required|string|in:public,private',
        ]);

        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'status' => 'open',
            'visibility' => $request->visibility,
        ]);

        return redirect()->route('home');
    }

    public function show(Project $project)
    {
        return Inertia::render('Project/Show', [
            'project' => $project->load('users', 'issues'),
            'issues' => $project->issues->load('labels')
        ]);
    }

    public function addUsers(Request $request, Project $project)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        // Attach users to the project
        $project->users()->syncWithoutDetaching($validated['user_ids']);

        return redirect()->route('project.show', $project);
    }

    public function edit(Project $project)
    {
        return Inertia::render('Project/Edit', [
            'project' => $project,
        ]);
    }

}
