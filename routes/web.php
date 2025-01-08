<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserRoleManagementController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/user-role-management', [UserRoleManagementController::class, 'index'])->name('user-role-management');
    Route::patch('/user-role-management/{user}', [UserRoleManagementController::class, 'update'])->name('user-role-management.update');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

    Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/project/create', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/{project}', [ProjectController::class, 'show'])->name('project.show');
    Route::get('/project/{project}/edit', [ProjectController::class, 'edit'])
        ->name('project.edit')
        ->can('edit', 'project');

    Route::patch('/project/{project}', [ProjectController::class, 'update'])->name('project.update');
    Route::get('/project/{project}/add-users', [ProjectController::class, 'showAddUsers'])->name('project.ShowProjectUsers');
    Route::post('/project/{project}/add-users', [ProjectController::class, 'addUsers'])
        ->name('project.add-users')
        ->can('add', 'project');

    Route::delete('/project/{project}/add-users/{user}', [ProjectController::class, 'removeUser'])
        ->name('project.removeUser')
        ->can('delete', 'project');

    Route::get('/project/{project}/issue', [IssueController::class, 'create'])->name('issue.create');
    Route::post('/project/{project}/issue', [IssueController::class, 'store'])->name('issue.store');
    Route::get('/projects/{project}/issues/{issue}', [IssueController::class, 'show'])->name('issue.show');
    Route::get('/projects/{project}/issues/{issue}/edit', [IssueController::class, 'edit'])
        ->name('issue.edit');
    Route::patch('/projects/{project}/issues/{issue}', [IssueController::class, 'update'])->name('issue.update');

    Route::post('/projects/{project}/issues/{issue}/comments', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/projects/{project}/issues/{issue}/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');
});

require __DIR__ . '/auth.php';
