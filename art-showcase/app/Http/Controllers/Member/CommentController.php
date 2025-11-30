<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Artwork $artwork)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Harus login terlebih dahulu');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['artwork_id'] = $artwork->id;
        $validated['status'] = 'approved';

        Comment::create($validated);

        return redirect()->route('artworks.show', $artwork)->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function destroy(Comment $comment)
    {
        // Check ownership or admin
        if ($comment->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $artwork = $comment->artwork;
        $comment->delete();

        return redirect()->route('artworks.show', $artwork)->with('success', 'Komentar berhasil dihapus!');
    }
}

