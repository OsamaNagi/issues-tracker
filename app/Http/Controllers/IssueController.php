<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Labels;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IssueController extends Controller
{
    use HasFactory;


    public function create(Project $project)
    {
        $labels = Labels::all();

        return Inertia::render('Issue/Create', [
            'project' => $project,
            'labels' => $labels,
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string|in:low,medium,high,critical',
            'label_id' => 'nullable|exists:labels,id',
        ]);

        $validated['created_by'] = auth()->id();

        $issue = $project->issues()->create($validated);

        if ($request->label_id) {
            $issue->labels()->attach($request->label_id);
        }

        return redirect()->route('project.show', $project);
    }

    public function show(Project $project, Issue $issue)
    {
        $issue = $issue->load(['comments.user', 'labels', 'project']); // Eager load relations

        return Inertia::render('Issue/Show', [
            'project' => $project,
            'issue' => $issue,
            'comments' => $issue->comments,
        ]);
    }
}
