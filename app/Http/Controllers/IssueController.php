<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    use HasFactory;

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Issue::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'open',
            'project_id' => $request->project_id,
            'created_by' => $request->user()->id,
            'assigned_id' => $request->assigned_id,
            'priority' => $request->priority,
        ]);

        return redirect()->route('project.show');
    }
}
