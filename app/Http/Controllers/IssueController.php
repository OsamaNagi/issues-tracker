<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIssueRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\UserResource;
use App\Models\Issue;
use App\Models\Labels;
use App\Models\Project;
use App\Notifications\NewIssueOpenedNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;

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

        // notify the project users about the new issue created in the project by the user who created it
        $project->users()
            ->where('users.id', '!=', auth()->id())
            ->get()
            ->each(function ($user) use ($issue) {
                $user->notify(new NewIssueOpenedNotification($issue));
            });

        return redirect()->route('project.show', $project);
    }

    public function show(Project $project, Issue $issue)
    {
        $issue = $issue->load(['labels', 'project', 'creator', 'assignees']);

        $issue->canEdit = auth()->user()->can('edit', $issue);

        // Get the activity log for the issue with the user who performed the activity info like name and avatar
        $activityLog = Activity::query()
            ->where('subject_id', $issue->id)
            ->where('subject_type', Issue::class)
            ->with('causer', 'subject')
            ->get();

        // dd($activityLog);

        return Inertia::render('Issue/Show', [
            'project' => $project,
            'issue' => $issue,
            'comments' => CommentResource::collection($issue->comments()->with(['user'])->paginate(5)),
            'assignees' => UserResource::collection($issue->assignees),
            'activityLog' => $activityLog,
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

        $original = $issue->getOriginal();

        $issue->update(Arr::except($validatedData, ['label_ids', 'assignee_ids']));

        if ($request->label_ids) {
            $issue->labels()->sync($request->label_ids);
        } else {
            $issue->labels()->detach();
        }

        if ($request->assignee_ids) {
            $issue->assignees()->sync($request->assignee_ids);
        } else {
            $issue->assignees()->detach();
        }

        $changes = $issue->getChanges();

        foreach ($changes as $field => $newValue) {
            if (in_array($field, ['updated_at', 'created_at'])) {
                continue;
            }

            $originalValue = $original[$field] ?? null;

            if ($originalValue != $newValue) {
                activity()
                    ->useLog('issue_activity')
                    ->performedOn($issue)
                    ->causedBy(auth()->user())
                    ->withProperties([
                        'field' => $field,
                        'old_value' => $originalValue,
                        'new_value' => $newValue,
                    ])
                    ->log("updated the {$field} to '{$newValue}'");
            }
        }

        return redirect()->route('issue.show', [$project, $issue]);
    }

    public function destroy(Project $project, Issue $issue)
    {
        $issue->delete();

        return redirect()->route('project.show', $project);
    }

    public function close(Project $project, Issue $issue)
    {
        $issue->update(['status' => 'closed']);

        activity()
            ->useLog('close_issue')
            ->performedOn($issue)
            ->causedBy(auth()->user())
            ->log('closed this issue');

        return redirect()->route('issue.show', [$project, $issue]);
    }

    public function reopen(Project $project, Issue $issue)
    {
        $issue->update(['status' => 'open']);

        activity()
            ->useLog('reopen_issue')
            ->performedOn($issue)
            ->causedBy(auth()->user())
            ->log('reopened this issue');

        return redirect()->route('issue.show', [$project, $issue]);
    }
}
