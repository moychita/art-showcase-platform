<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Artwork;
use App\Models\Comment;
use App\Models\Report;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Tambahkan import Storage

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan statistik dan data terbaru.
     */
    public function dashboard()
    {
        // Statistik Umum
        $stats = [
            'total_users' => User::count(),
            'total_members' => User::where('role', 'member')->count(),
            'total_curators' => User::where('role', 'curator')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'pending_curators' => User::where('role', 'curator')->where('status', 'pending')->count(),
            
            'total_artworks' => Artwork::count(),
            'pending_artworks' => Artwork::where('status', 'pending')->count(),
            'rejected_artworks' => Artwork::where('status', 'rejected')->count(),
            
            'total_reports' => Report::count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
            
            'total_likes' => \App\Models\Like::count(),
            'total_comments' => Comment::count(),
            'total_categories' => Category::count(),
        ];

        // Data Terbaru untuk Ditampilkan di Dashboard
        $recentReports = Report::with(['user', 'reportable', 'reviewer'])
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        $pendingArtworks = Artwork::with(['user', 'category'])
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        $pendingCurators = User::where('role', 'curator')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.dashboard', compact('stats', 'recentReports', 'pendingArtworks', 'pendingCurators'));
    }

    /**
     * Menampilkan daftar pengguna.
     */
    public function users()
    {
        $users = User::where('id', '!=', auth()->id())
            ->latest()
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Memperbarui data pengguna (role & status).
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,member,curator',
            'status' => 'required|in:active,pending,suspended',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'Data pengguna berhasil diperbarui');
    }

    /**
     * Menghapus pengguna.
     */
    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus');
    }

    /**
     * Menampilkan daftar laporan (Moderasi Konten).
     */
    public function reports()
    {
        $reports = Report::with(['user', 'reportable', 'reviewer'])
            ->where('status', 'pending') // Filter hanya laporan yang pending
            ->latest()
            ->paginate(10);

        return view('admin.reports', compact('reports'));
    }

    /**
     * Memproses tinjauan laporan (Approve/Dismiss).
     */
    public function reviewReport(Request $request, Report $report)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,dismiss', // approve = hapus konten, dismiss = tolak laporan
        ]);

        if ($validated['action'] === 'approve') {
            // Jika laporan disetujui, maka konten yang dilaporkan DIHAPUS
            if ($report->reportable) {
                // Jika Artwork, hapus gambarnya dari storage
                if ($report->reportable_type === 'App\Models\Artwork') {
                    Storage::disk('public')->delete($report->reportable->media_path);
                }
                
                // Hapus data dari database
                $report->reportable->delete();
            }

            $report->status = 'resolved'; 
            $message = 'Laporan disetujui. Konten telah dihapus.';

        } else {
            // Jika laporan ditolak (dianggap tidak melanggar)
            $report->status = 'dismissed';
            $message = 'Laporan ditolak. Konten tetap aman.';
        }

        // Catat admin yang mereview
        $report->reviewed_by = auth()->id();
        $report->reviewed_at = now();
        $report->save();

        return back()->with('success', $message);
    }

    /**
     * Moderasi Artwork secara langsung (tanpa lewat laporan).
     */
    public function moderateArtwork(Request $request, Artwork $artwork)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        $artwork->status = $validated['action'] === 'approve' ? 'approved' : 'rejected';
        $artwork->save();

        return redirect()->back()->with('success', 'Status karya berhasil diperbarui');
    }

    /**
     * Moderasi Komentar secara langsung.
     */
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