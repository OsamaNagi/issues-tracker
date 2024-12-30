<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIssueRequest;
use App\Models\Issue;
use App\Models\Labels;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class IssueController extends Controller
{
    use HasFactory;


    public function create(Project $project)
    {
        $labels = Labels::all();
        $projectUsers = $project->users()->get();

        return Inertia::render('Issue/Create', [
            'project' => $project,
            'labels' => $labels,
            'projectUsers' => $projectUsers,
        ]);
    }

    public function store(StoreIssueRequest $request, Project $project)
    {
        $validatedData = $request->validated();
        $validatedData['created_by'] = auth()->id();

        // Create the issue while excluding label_id and assignee_ids
        $issue = $project->issues()->create(Arr::except($validatedData, ['label_ids', 'assignee_ids']));

        // Attach labels if provided
        if ($request->label_ids) {
            $issue->labels()->attach($request->label_ids);
        }

        // Attach assignees if provided
        if ($request->assignee_ids) {
            $issue->assignees()->attach($request->assignee_ids);
        }

        return redirect()->route('project.show', $project);
    }

    public function show(Project $project, Issue $issue)
    {
        $issue = $issue->load(['comments.user', 'labels', 'project', 'creator', 'assignees']);

        return Inertia::render('Issue/Show', [
            'project' => $project,
            'issue' => $issue,
            'comments' => $issue->comments,
            'assignees' => $issue->assignees,
        ]);
    }

    public function edit(Project $project, Issue $issue)
    {
        $labels = Labels::all();
        $projectUsers = $project->users()->get();

        return Inertia::render('Issue/Edit', [
            'project' => $project,
            'issue' => $issue->load('labels', 'assignees'),
            'labels' => $labels,
            'projectUsers' => $projectUsers,
        ]);
    }

    public function update(StoreIssueRequest $request, Project $project, Issue $issue)
    {
        $validatedData = $request->validated();

        // Update the issue while excluding label_id and assignee_ids
        $issue->update(Arr::except($validatedData, ['label_ids', 'assignee_ids']));

        // Sync labels if provided
        if ($request->label_ids) {
            $issue->labels()->sync($request->label_ids);
        } else {
            $issue->labels()->detach();
        }

        // Sync assignees if provided
        if ($request->assignee_ids) {
            $issue->assignees()->sync($request->assignee_ids);
        } else {
            $issue->assignees()->detach();
        }

        return redirect()->route('issue.show', [$project, $issue]);
    }
}
