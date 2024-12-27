<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    use HasFactory;

    public function store(Request $request, Project $project)
    {
         $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string|in:low,medium,high,critical',
        ]);

        $validated['created_by'] = auth()->id();

        $project->issues()->create($validated);

        return redirect()->back()->with('success', 'Issue created successfully!');
    }
}
