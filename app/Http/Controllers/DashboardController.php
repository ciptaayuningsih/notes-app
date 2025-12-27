<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        return Inertia::render('Dashboard', [
            'stats' => [
                'notes' => $user->notes()->count(),
                'subjects' => $user->subjects()->count(),
                'favorites' => $user->notes()->where('is_favorite', true)->count(),
            ],
            'latestNotes' => $user->notes()
                ->with('subject')
                ->latest()
                ->take(4)
                ->get(),
        ]);
    }
}
