<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $publicProjects = Project::public()->count();
        $privateProjects = Project::private()->count();

        return Inertia::render('Home', [
            'publicProjects' => $publicProjects,
            'privateProjects' => $privateProjects,
        ]);
    }
}
