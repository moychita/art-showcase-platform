<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Favorite;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        $stats = [
            'total_artworks' => $user->artworks()->count(),
            'total_likes' => $user->artworks()->withCount('likes')->get()->sum('likes_count'),
            'total_views' => $user->artworks()->sum('views'),
            'total_favorites' => $user->artworks()->withCount('favorites')->get()->sum('favorites_count'),
        ];

        $recentArtworks = $user->artworks()
            ->with(['category', 'likes', 'favorites'])
            ->latest()
            ->take(10)
            ->get();

        $favoritedArtworks = Favorite::where('user_id', $user->id)
            ->with(['artwork.user', 'artwork.category'])
            ->latest()
            ->take(10)
            ->get()
            ->pluck('artwork');

        return view('member.dashboard', compact('stats', 'recentArtworks', 'favoritedArtworks'));
    }

    public function myArtworks()
    {
        $artworks = auth()->user()->artworks()
            ->with(['category', 'likes', 'favorites', 'comments'])
            ->latest()
            ->paginate(12);

        return view('member.artworks', compact('artworks'));
    }
}
