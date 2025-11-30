<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    // --- FUNGSI 1: INDEX (DAFTAR CHALLENGE) ---
    // Dipanggil saat membuka halaman /challenges
    public function index()
    {
        // Mengambil data challenge yang statusnya 'active' atau 'closed'
        $challenges = Challenge::whereIn('status', ['active', 'closed'])
            ->orderBy('status', 'asc') // Active (a) akan muncul sebelum Closed (c)
            ->orderBy('end_date', 'desc') // Urutkan deadline paling lama/baru
            ->paginate(9); // Batasi 9 item per halaman

        return view('curator/challenges.index', compact('challenges'));
    }

    // --- FUNGSI 2: SHOW (DETAIL CHALLENGE) ---
    // Dipanggil saat membuka halaman /challenges/{id}
    public function show(Challenge $challenge)
    {
        // Validasi: Jika statusnya masih 'draft', jangan tampilkan (Error 404)
        // Ini untuk mencegah user melihat challenge yang belum dirilis
        if ($challenge->status === 'draft') {
            abort(404);
        }

        // Ambil karya (submissions) yang dikirim ke challenge ini
        $submissions = $challenge->artworks()
            ->where('status', 'approved') // Hanya yang sudah disetujui admin
            ->with('user') // Ambil data user pembuatnya sekaligus (biar cepat)
            ->latest() // Urutkan dari yang terbaru
            ->paginate(12); // Batasi 12 gambar per halaman

        // Kirim data $challenge (info lomba) dan $submissions (karya peserta) ke view
        return view('curator.challenges.show', compact('challenge', 'submissions'));
    }
}