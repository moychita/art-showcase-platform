@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Moderasi Laporan</h1>
            <p class="text-gray-500 mt-1">Tinjau laporan konten dari komunitas.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
            ← Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelapor</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Target</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alasan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($reports as $report)
                    <tr>
                        <td class="px-4 py-4 text-sm">
                            <div class="font-semibold text-gray-900">{{ $report->user->name }}</div>
                            <div class="text-gray-500">{{ $report->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            {{ class_basename($report->reportable_type) }} #{{ $report->reportable_id }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            <div class="font-semibold capitalize">{{ $report->reason }}</div>
                            <p class="text-gray-500 text-sm mt-1">{{ $report->description ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-4 text-sm capitalize text-gray-700">
                            {{ $report->status }}
                        </td>
                        <td class="px-4 py-4 space-y-2">
                            <form method="POST" action="{{ route('admin.reports.review', $report) }}">
                                @csrf
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                    Take Down
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.reports.review', $report) }}">
                                @csrf
                                <input type="hidden" name="action" value="dismiss">
                                <button type="submit" class="text-sm text-gray-600 hover:text-gray-800">
                                    Dismiss
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">
                            Tidak ada laporan untuk ditinjau.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $reports->links() }}
    </div>
</div>
@endsection

