<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    public function index(Request $request)
    {
        $query = Artwork::with(['user', 'category', 'likes', 'favorites'])
            ->where('status', 'approved');

        // Filter by category
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $artworks = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('artworks.index', compact('artworks', 'categories'));
    }

    public function show(Artwork $artwork)
    {
        // Increment views
        $artwork->increment('views');
        
        $artwork->load(['user', 'category', 'challenge', 'comments.user', 'likes', 'favorites']);
        
        $isLiked = auth()->check() ? $artwork->isLikedBy(auth()->id()) : false;
        $isFavorited = auth()->check() ? $artwork->isFavoritedBy(auth()->id()) : false;

        return view('artworks.show', compact('artwork', 'isLiked', 'isFavorited'));
    }

    public function create()
    {
        $categories = Category::all();
        $challenges = Challenge::where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('artworks.create', compact('categories', 'challenges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'media' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'category_id' => 'nullable|exists:categories,id',
            'challenge_id' => 'nullable|exists:challenges,id',
        ]);

        // Upload media
        if ($request->hasFile('media')) {
            $validated['media_path'] = $request->file('media')->store('artworks', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'approved'; // Auto approve untuk member

        Artwork::create($validated);

        return redirect()->route('artworks.index')->with('success', 'Karya berhasil diunggah!');
    }

    public function edit(Artwork $artwork)
    {
        // Check ownership
        if ($artwork->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::all();
        $challenges = Challenge::where('status', 'active')->get();

        return view('artworks.edit', compact('artwork', 'categories', 'challenges'));
    }

    public function update(Request $request, Artwork $artwork)
    {
        // Check ownership
        if ($artwork->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'media' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'category_id' => 'nullable|exists:categories,id',
            'challenge_id' => 'nullable|exists:challenges,id',
        ]);

        // Update media if new file uploaded
        if ($request->hasFile('media')) {
            // Delete old media
            if ($artwork->media_path) {
                Storage::disk('public')->delete($artwork->media_path);
            }
            $validated['media_path'] = $request->file('media')->store('artworks', 'public');
        }

        $artwork->update($validated);

        return redirect()->route('artworks.show', $artwork)->with('success', 'Karya berhasil diperbarui!');
    }

    public function destroy(Artwork $artwork)
    {
        // Check ownership or admin
        if ($artwork->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        // Delete media
        if ($artwork->media_path) {
            Storage::disk('public')->delete($artwork->media_path);
        }

        $artwork->delete();

        return redirect()->route('artworks.index')->with('success', 'Karya berhasil dihapus!');
    }
}

