<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\User;
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
            ->paginate(10);

        return Inertia::render('Projects', [
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

        return redirect()->route('projects.index');
    }

    public function show(Project $project)
    {
        $issues = $project->issues()->with('labels')->paginate(10);

        return Inertia::render('Project/Show', [
            'project' => $project->load('users', 'issues'),
            'issues' => $issues
        ]);
    }

    public function edit(Project $project)
    {
        return Inertia::render('Project/Edit', [
            'project' => $project,
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'visibility' => 'required|string|in:public,private',
        ]);

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'visibility' => $request->visibility,
        ]);

        return redirect()->route('projects.index', $project);
    }

    public function showAddUsers(Project $project)
    {
        // This is to prevent the project owner and the users already in the project from being added again
        $users = User::where('id', '!=', $project->user_id)
            ->whereDoesntHave('projects', function ($query) use ($project) {
                $query->where('project_id', $project->id);
            })
            ->get();

        $ProjectUsers = $project->users()->where('user_id', '!=', $project->user_id)
            ->with('roles')
            ->get();

        return Inertia::render('Project/ShowProjectUsers', [
            'project' => $project,
            'projectUsers' => UserResource::collection($ProjectUsers),
            'users' => $users,
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

        return redirect()->route('project.add-users', $project);
    }

    public function removeUser(Project $project, User $user)
    {
        $project->users()->detach($user);

        return redirect()->route('project.add-users', $project);
    }
}
