<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
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
            ->paginate(5);

        return view('curator.dashboard', compact('stats', 'challenges'));
    }

    // --- 1. TAMPILKAN FORMULIR ---
    public function createChallenge()
    {
        // Ini yang memanggil view 'curator.challenges.create'
        return view('curator.challenges.create');
    }

    // --- 2. PROSES SIMPAN DATA ---
    public function storeChallenge(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Max 5MB
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('challenges', 'public');
        }

        // Otomatis isi curator_id dengan user yang sedang login
        $validated['curator_id'] = auth()->id();
        $validated['status'] = 'active'; // Langsung aktif

        Challenge::create($validated);

        return redirect()->route('curator.dashboard')->with('success', 'Challenge berhasil dibuat!');
    }

    // ... (Sisa method showChallenge, editChallenge, dll tetap sama) ...
    
    public function showChallenge(Challenge $challenge)
    {
        if ($challenge->curator_id !== auth()->id()) abort(403);
        
        $artworks = $challenge->artworks()
            ->with(['user', 'likes'])
            ->where('status', 'approved')
            ->latest()
            ->paginate(12);

        return view('curator.challenges.show', compact('challenge', 'artworks'));
    }

    public function editChallenge(Challenge $challenge)
    {
        if ($challenge->curator_id !== auth()->id()) abort(403);
        return view('curator.challenges.edit', compact('challenge'));
    }

    public function updateChallenge(Request $request, Challenge $challenge)
    {
        if ($challenge->curator_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,active,closed',
        ]);

        if ($request->hasFile('image')) {
            if ($challenge->image) Storage::disk('public')->delete($challenge->image);
            $validated['image'] = $request->file('image')->store('challenges', 'public');
        }

        $challenge->update($validated);

        return redirect()->route('curator.challenges.show', $challenge)->with('success', 'Challenge diperbarui!');
    }

    public function selectWinner(Request $request, Challenge $challenge)
    {
        if ($challenge->curator_id !== auth()->id()) abort(403);
        
        $validated = $request->validate(['winner_artwork_id' => 'required|exists:artworks,id']);
        
        $challenge->winner_artwork_id = $validated['winner_artwork_id'];
        $challenge->status = 'closed';
        $challenge->save();

        return redirect()->route('curator.challenges.show', $challenge)->with('success', 'Pemenang dipilih!');
    }

    public function destroy(\App\Models\Challenge $challenge)
    {
        // Pastikan hanya pemilik yang bisa hapus
        if ($challenge->curator_id !== auth()->id()) {
            abort(403);
        }

        // Hapus gambar banner jika ada
        if ($challenge->image) {
            Storage::disk('public')->delete($challenge->image);
        }

        $challenge->delete();

        return redirect()->route('curator.dashboard')->with('success', 'Challenge berhasil dihapus!');
    }
}