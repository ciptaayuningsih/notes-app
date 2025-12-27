<?php

namespace App\Http\Controllers;

use App\Models\Note;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NoteController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return Inertia::render('Notes/Index', [
            'notes' => $user->notes()
                ->with('subject')
                ->latest()
                ->get(),
            'subjects' => $user->subjects,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        auth()->user()->notes()->create($data);

        return back();
    }

    public function update(Request $request, Note $note)
    {
        $note->update(
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'subject_id' => 'required',
            ])
        );

        return back();
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return back();
    }
}
