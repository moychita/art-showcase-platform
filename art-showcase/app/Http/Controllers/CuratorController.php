<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CuratorController extends Controller
{
    public function dashboard()
    {
        $curator = auth()->user();
        
        $stats = [
            'total_challenges' => $curator->challenges()->count(),
            'active_challenges' => $curator->challenges()->where('status', 'active')->count(),
            'closed_challenges' => $curator->challenges()->where('status', 'closed')->count(),
            'total_submissions' => Artwork::whereIn('challenge_id', $curator->challenges()->pluck('id'))->count(),
        ];

        $challenges = $curator->challenges()
            ->with(['artworks', 'winner'])
            ->latest()
            ->paginate(10);

        return view('curator.dashboard', compact('stats', 'challenges'));
    }

    public function challenges()
    {
        $challenges = auth()->user()->challenges()
            ->with(['artworks', 'winner'])
            ->latest()
            ->paginate(12);

        return view('curator.challenges.index', compact('challenges'));
    }

    public function createChallenge()
    {
        return view('curator.challenges.create');
    }

    public function storeChallenge(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('challenges', 'public');
        }

        $validated['curator_id'] = auth()->id();
        $validated['status'] = 'draft';

        Challenge::create($validated);

        return redirect()->route('curator.challenges')->with('success', 'Challenge berhasil dibuat!');
    }

    public function editChallenge(Challenge $challenge)
    {
        // Check ownership
        if ($challenge->curator_id !== auth()->id()) {
            abort(403);
        }

        return view('curator.challenges.edit', compact('challenge'));
    }

    public function updateChallenge(Request $request, Challenge $challenge)
    {
        // Check ownership
        if ($challenge->curator_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,active,closed',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($challenge->image) {
                Storage::disk('public')->delete($challenge->image);
            }
            $validated['image'] = $request->file('image')->store('challenges', 'public');
        }

        $challenge->update($validated);

        return redirect()->route('curator.challenges')->with('success', 'Challenge berhasil diperbarui!');
    }

    public function showChallenge(Challenge $challenge)
    {
        // Check ownership
        if ($challenge->curator_id !== auth()->id()) {
            abort(403);
        }

        $artworks = $challenge->artworks()
            ->with(['user', 'likes', 'favorites'])
            ->latest()
            ->get();

        return view('curator.challenges.show', compact('challenge', 'artworks'));
    }

    public function selectWinner(Request $request, Challenge $challenge)
    {
        // Check ownership
        if ($challenge->curator_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'winner_artwork_id' => 'required|exists:artworks,id',
        ]);

        // Verify artwork belongs to challenge
        $artwork = Artwork::where('id', $validated['winner_artwork_id'])
            ->where('challenge_id', $challenge->id)
            ->firstOrFail();

        $challenge->winner_artwork_id = $artwork->id;
        $challenge->status = 'closed';
        $challenge->save();

        return redirect()->route('curator.challenges.show', $challenge)
            ->with('success', 'Pemenang challenge berhasil dipilih!');
    }
}
