<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Notifications\AddCommentNotification;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Project $project, Issue $issue)
    {
        $request->validate([
            'content' => 'string'
        ]);

        $issue->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('content')
        ]);

        $issue->assignees()
            ->where('user_id', '!=', auth()->id())
            ->get()
            ->each(function ($user) use ($issue) {
                $user->notify(new AddCommentNotification($issue));
            });

        activity()
            ->useLog('comment')
            ->performedOn($issue)
            ->causedBy(auth()->user())
            ->withProperties(['content' => $request->input('content')])
            ->log('commented on issue');

        return redirect()->route('issue.show', [$issue->project, $issue]);
    }

    public function destroy(Project $project, Issue $issue, Comment $comment)
    {
        $comment->delete();

        return redirect()->route('issue.show', [$issue->project, $issue]);
    }
}
