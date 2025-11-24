<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    public function index()
    {
        $artworks = Artwork::all();
        return view('layouts.artworks.index', compact('artworks'));
    }

    public function create()
    {
        return view('layouts.artworks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'media_path' => 'required',
        ]);
        $validated['user_id'] = auth()->id(); // Pastikan sudah login yaa

        Artwork::create($validated);

        return redirect()->route('artworks.index');
    }

    public function show(Artwork $artwork)
    {
        return view('layouts.artworks.show', compact('artwork'));
    }

    public function edit(Artwork $artwork)
    {
        return view('layouts.artworks.edit', compact('artwork'));
    }

    public function update(Request $request, Artwork $artwork)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'media_path' => 'required',
        ]);

        $artwork->update($validated);

        return redirect()->route('artworks.index');
    }

    public function destroy(Artwork $artwork)
    {
        $artwork->delete();
        return redirect()->route('artworks.index');
    }
}
