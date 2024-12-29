<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Project $project, Issue $issue)
    {
        $request->validate([
            'content' => 'string'
        ]);

        $issue->comments()->create([
            'content' => $request->input('content'),
            'user_id' => auth()->id()
        ]);

        return redirect()->route('issue.show', [$issue->project, $issue]);
    }
}
