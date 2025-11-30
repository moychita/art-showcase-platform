<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CuratorController extends Controller
{
    // 1. Dashboard Utama Curator
    public function dashboard()
    {
        $curator = auth()->user();
        
        // Mengambil statistik untuk ditampilkan di dashboard
        $stats = [
            'total_challenges' => $curator->challenges()->count(),
            'active_challenges' => $curator->challenges()->where('status', 'active')->count(),
            'closed_challenges' => $curator->challenges()->where('status', 'closed')->count(),
            'total_submissions' => Artwork::whereIn('challenge_id', $curator->challenges()->pluck('id'))->count(),
        ];

        // List challenge terbaru (limit 5) untuk dashboard
        $challenges = $curator->challenges()
            ->with(['artworks', 'winner'])
            ->latest()
            ->paginate(5);

        return view('curator.dashboard', compact('stats', 'challenges'));
    }

    // 2. Halaman List Semua Challenge
    public function challenges()
    {
        // Redirect ke dashboard saja karena di sana sudah ada list challenge
        return redirect()->route('curator.dashboard');
    }

    // 3. Form Upload Challenge (Create)
    public function createChallenge()
    {
        return view('curator.challenges.create');
    }

    // 4. Proses Simpan Challenge Baru (Store)
    public function storeChallenge(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Max 5MB
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Upload Gambar Banner (jika ada)
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('challenges', 'public');
        }

        // Otomatis isi curator_id dengan user yang sedang login
        $validated['curator_id'] = auth()->id();
        $validated['status'] = 'active'; // Langsung aktif

        Challenge::create($validated);

        return redirect()->route('curator.dashboard')->with('success', 'Challenge berhasil dibuat!');
    }

    // 5. Detail Challenge & Submisi (PERBAIKAN VARIABEL $submissions)
    public function showChallenge(Challenge $challenge)
    {
        // Keamanan: Pastikan challenge ini milik curator yang sedang login
        if ($challenge->curator_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil semua karya yang disubmit ke challenge ini
        $submissions = $challenge->artworks()
            ->with(['user', 'likes'])
            ->where('status', 'approved') // Hanya tampilkan yang sudah diapprove admin
            ->latest()
            ->paginate(12);

        // Kirim dengan nama variabel 'submissions' agar sesuai view
        return view('curator.challenges.show', compact('challenge', 'submissions'));
    }

    // 6. Form Edit Challenge
    public function editChallenge(Challenge $challenge)
    {
        // Keamanan: Cek kepemilikan
        if ($challenge->curator_id !== auth()->id()) {
            abort(403);
        }

        return view('curator.challenges.edit', compact('challenge'));
    }

    // 7. Proses Update Challenge
    public function updateChallenge(Request $request, Challenge $challenge)
    {
        // Keamanan: Cek kepemilikan
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

        // Cek jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama agar hemat storage
            if ($challenge->image) {
                Storage::disk('public')->delete($challenge->image);
            }
            $validated['image'] = $request->file('image')->store('challenges', 'public');
        }

        $challenge->update($validated);

        return redirect()->route('curator.challenges.show', $challenge)->with('success', 'Challenge berhasil diperbarui!');
    }

    // 8. Memilih Pemenang
    public function selectWinner(Request $request, Challenge $challenge)
    {
        // 1. Cek apakah user yang login adalah pemilik challenge ini
        if ($challenge->curator_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Validasi input (ID artwork yang dipilih)
        $validated = $request->validate([
            'winner_artwork_id' => 'required|exists:artworks,id',
        ]);

        // 3. Verifikasi bahwa karya tersebut benar-benar disubmit untuk challenge ini
        $artwork = Artwork::where('id', $validated['winner_artwork_id'])
            ->where('challenge_id', $challenge->id)
            ->firstOrFail();

        // 4. Update data challenge
        $challenge->winner_artwork_id = $artwork->id;
        $challenge->status = 'closed'; // Otomatis tutup challenge setelah ada pemenang
        $challenge->save();

        return redirect()->route('curator.challenges.show', $challenge)
            ->with('success', 'Pemenang challenge berhasil dipilih!');
    }

    // 9. Hapus Challenge (Destroy)
    public function destroy(Challenge $challenge)
    {
        // Keamanan: Cek kepemilikan
        if ($challenge->curator_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus gambar banner jika ada
        if ($challenge->image) {
            Storage::disk('public')->delete($challenge->image);
        }

        // Hapus data dari database
        $challenge->delete();

        return redirect()->route('curator.dashboard')->with('success', 'Challenge berhasil dihapus!');
    }
}