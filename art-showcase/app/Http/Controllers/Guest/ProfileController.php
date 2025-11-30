<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // A. Halaman Profil Publik (Bisa dilihat siapa saja)
    public function show(User $user)
    {
        // Ambil karya user tersebut (yang approved)
        $artworks = $user->artworks()
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('profile.show', compact('user', 'artworks'));
    }

    // B. Halaman Edit Profil (Hanya pemilik akun)
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    // Proses Update Data Profil
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            // Validasi link sosmed (optional)
            'instagram' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        // Upload Avatar Baru
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Simpan Link Sosmed sebagai JSON
        $externalLinks = [
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'website' => $request->website,
        ];
        // Hapus nilai kosong agar rapi
        $validated['external_links'] = array_filter($externalLinks);

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}