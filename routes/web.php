<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('home');
    Route::get('/project', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/project', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/{project}', [ProjectController::class, 'show'])->name('project.show');
    Route::get('/project/{project}/edit', [ProjectController::class, 'edit'])->name('project.edit');
    Route::patch('/project/{project}', [ProjectController::class, 'update'])->name('project.update');

    Route::get('/project/{project}/issue', [IssueController::class, 'create'])->name('issue.create');
    Route::post('/project/{project}/issue', [IssueController::class, 'store'])->name('issue.store');
    Route::get('/projects/{project}/issues/{issue}', [IssueController::class, 'show'])->name('issue.show');
    Route::get('/projects/{project}/issues/{issue}/edit', [IssueController::class, 'edit'])->name('issue.edit');
    Route::patch('/projects/{project}/issues/{issue}', [IssueController::class, 'update'])->name('issue.update');

    Route::post('/projects/{project}/issues/{issue}/comments', [CommentController::class, 'store'])->name('comment.store');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
