<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Artwork $artwork)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Harus login terlebih dahulu'], 401);
        }

        $like = Like::where('user_id', auth()->id())
            ->where('artwork_id', $artwork->id)
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'artwork_id' => $artwork->id,
            ]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $artwork->likes()->count(),
        ]);
    }
}

