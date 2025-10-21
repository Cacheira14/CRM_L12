<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $visits = $user->isAdmin()
            ? Visit::with('client')->get()
            : $user->visits()->with('client')->get();

        $notes = $user->isAdmin()
            ? Note::with('visit.client')->paginate(10)
            : Note::whereHas('visit', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with('visit.client')->paginate(10);

        return view('notes.index', compact('notes', 'visits'));
    }

    public function create()
    {
        $user = Auth::user();

        $visits = $user->isAdmin()
            ? Visit::with('client')->get()
            : $user->visits()->with('client')->get();

        return view('notes.create', compact('visits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'content' => 'required|string',
        ]);

        $visit = Visit::findOrFail($validated['visit_id']);

        // Ensure user owns the visit or is admin
        if (!$visit->user->is(Auth::user()) && !Auth::user()->isAdmin()) {
            abort(403);
        }

        Note::create($validated);

        return redirect()->route('visits.index')->with('success', 'Note created successfully.');
    }

    public function edit(Note $note)
    {
        $this->authorize('update', $note);

        $user = Auth::user();

        $visits = $user->isAdmin()
            ? Visit::with('client')->get()
            : $user->visits()->with('client')->get();

        return view('notes.edit', compact('note', 'visits'));
    }

    public function update(Request $request, Note $note)
    {
        $this->authorize('update', $note);

        $validated = $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'content' => 'required|string',
        ]);

        $visit = Visit::findOrFail($validated['visit_id']);

        // Ensure user owns the visit or is admin
        if (!$visit->user->is(Auth::user()) && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $note->update($validated);

        return redirect()->route('visits.index')->with('success', 'Note updated successfully.');
    }

    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);

        $note->delete();

        return redirect()->route('visits.index')->with('success', 'Note deleted successfully.');
    }
}
