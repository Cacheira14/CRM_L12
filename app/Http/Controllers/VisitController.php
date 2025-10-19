<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $visits = $user->isAdmin()
            ? Visit::with('client', 'user')->get()
            : $user->visits()->with('client')->get();

        $clients = Client::all();

        return view('visits.index', compact('visits', 'clients'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('visits.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'scheduled_at' => 'required|date',
        ]);

        Visit::create([
            'user_id' => Auth::id(),
            'client_id' => $validated['client_id'],
            'scheduled_at' => $validated['scheduled_at'],
        ]);

        return redirect()->route('visits.index')->with('success', 'Visit scheduled successfully.');
    }

    public function edit(Visit $visit)
    {
        $this->authorize('update', $visit);

        $clients = Client::all();
        return view('visits.edit', compact('visit', 'clients'));
    }

    public function update(Request $request, Visit $visit)
    {
        $this->authorize('update', $visit);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'scheduled_at' => 'required|date',
            'completed_at' => 'nullable|date',
        ]);

        $visit->update($validated);

        return redirect()->route('visits.index')->with('success', 'Visit updated successfully.');
    }

    public function destroy(Visit $visit)
    {
        $this->authorize('delete', $visit);

        $visit->delete();

        return redirect()->route('visits.index')->with('success', 'Visit deleted successfully.');
    }
}
