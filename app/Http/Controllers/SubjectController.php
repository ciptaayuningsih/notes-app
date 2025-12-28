<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Subjects/Index', [
            'subjects' => auth()->user()->subjects()->withCount('notes')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        auth()->user()->subjects()->create([
            'name' => $request->name,
        ]);

        return back();
    }

    public function update(Request $request, Subject $subject)
    {
        $subject->update(
            $request->validate(['name' => 'required'])
        );

        return back();
    }

    public function destroy(Subject $subject)
    {
        // Prevent deletion if subject has notes
        if ($subject->notes()->count() > 0) {
            return back()->withErrors(['subject' => 'Tidak dapat menghapus mata pelajaran yang memiliki catatan.']);
        }

        $subject->delete();
        return back();
    }
}
