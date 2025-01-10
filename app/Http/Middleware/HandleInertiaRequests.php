<?php

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'appName' => config('app.name'),
            'auth' => [
                'user' => UserResource::make($request->user())->resolve($request),
                'check' => fn() => Auth::check(),
                'isAdmin' => fn() => Auth::check() && Auth::user()->isAdmin(),
            ],
            'ziggy' => fn() => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'notificationsCount' => function () {
                // Retrieve unread notifications for the authenticated user
                $user = auth()->user();
                return $user ? $user->unreadNotifications->count() : 0;
            },
            'notifications' => function () {
                // Retrieve unread notifications for the authenticated user
                $user = auth()->user();
                return $user ? NotificationResource::collection($user->notifications) : [];
            },
        ];
    }
}
