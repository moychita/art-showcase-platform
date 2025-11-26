<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artwork;
use App\Models\Comment;
use App\Models\Report;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_members' => User::where('role', 'member')->count(),
            'total_curators' => User::where('role', 'curator')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'pending_curators' => User::where('role', 'curator')
                                    ->where('status', 'pending')
                                    ->count(),
            'total_artworks' => Artwork::count(),
            'pending_artworks' => Artwork::where('status', 'pending')->count(),
            'rejected_artworks' => Artwork::where('status', 'rejected')->count(),
            'total_reports' => Report::count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
            'total_likes' => \App\Models\Like::count(),
            'total_comments' => Comment::count(),
            'total_categories' => Category::count(),
        ];

        // Recent reports
        $recentReports = Report::with(['user', 'reportable', 'reviewer'])
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        // Recent artworks pending approval
        $pendingArtworks = Artwork::with(['user', 'category'])
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentReports', 'pendingArtworks'));
    }

    public function users()
    {
        $users = User::where('id', '!=', auth()->id())
            ->latest()
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,member,curator',
            'status' => 'required|in:active,pending,suspended',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus');
    }

    // Moderasi Konten
    public function reports()
    {
        $reports = Report::with(['user', 'reportable', 'reviewer'])
            ->latest()
            ->paginate(20);

        return view('admin.reports', compact('reports'));
    }

    public function reviewReport(Request $request, Report $report)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject,dismiss',
        ]);

        if ($validated['action'] === 'approve') {
            // Delete reported content
            if ($report->reportable) {
                $report->reportable->delete();
            }
            $report->status = 'resolved';
        } elseif ($validated['action'] === 'reject') {
            $report->status = 'dismissed';
        } else {
            $report->status = 'dismissed';
        }

        $report->reviewed_by = auth()->id();
        $report->reviewed_at = now();
        $report->save();

        return redirect()->route('admin.reports')->with('success', 'Laporan berhasil ditinjau');
    }

    public function moderateArtwork(Request $request, Artwork $artwork)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        $artwork->status = $validated['action'] === 'approve' ? 'approved' : 'rejected';
        $artwork->save();

        return redirect()->back()->with('success', 'Status karya berhasil diperbarui');
    }

    public function moderateComment(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject,delete',
        ]);

        if ($validated['action'] === 'delete') {
            $comment->delete();
        } else {
            $comment->status = $validated['action'] === 'approve' ? 'approved' : 'rejected';
            $comment->save();
        }

        return redirect()->back()->with('success', 'Status komentar berhasil diperbarui');
    }
}
