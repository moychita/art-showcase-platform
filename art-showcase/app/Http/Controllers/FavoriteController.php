<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Artwork $artwork)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Harus login terlebih dahulu'], 401);
        }

        $favorite = Favorite::where('user_id', auth()->id())
            ->where('artwork_id', $artwork->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $favorited = false;
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'artwork_id' => $artwork->id,
            ]);
            $favorited = true;
        }

        return response()->json([
            'favorited' => $favorited,
            'favorites_count' => $artwork->favorites()->count(),
        ]);
    }

    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $artworks = auth()->user()->favorites()->with(['artwork.user', 'artwork.category'])->get()
            ->pluck('artwork');

        return view('favorites.index', compact('artworks'));
    }
}

