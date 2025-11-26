<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Harus login terlebih dahulu');
        }

        $validated = $request->validate([
            'reportable_type' => 'required|in:App\Models\Artwork,App\Models\Comment',
            'reportable_id' => 'required|integer',
            'reason' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Check if already reported
        $existingReport = Report::where('user_id', auth()->id())
            ->where('reportable_type', $validated['reportable_type'])
            ->where('reportable_id', $validated['reportable_id'])
            ->where('status', 'pending')
            ->first();

        if ($existingReport) {
            return back()->with('error', 'Anda sudah melaporkan item ini sebelumnya');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        Report::create($validated);

        return back()->with('success', 'Laporan berhasil dikirim. Admin akan meninjau laporan ini.');
    }
}

