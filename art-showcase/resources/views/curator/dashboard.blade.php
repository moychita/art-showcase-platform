@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard Curator</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Total Challenge</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_challenges'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Sedang Aktif</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_challenges'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Selesai</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['closed_challenges'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Total Submisi</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_submissions'] ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Challenge Terbaru</h2>
        <div class="space-y-4">
            @forelse ($challenges as $challenge)
                <div class="border border-gray-100 rounded p-4 flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <p class="font-semibold text-gray-900">{{ $challenge->title }}</p>
                        <span class="text-xs uppercase text-gray-500">{{ $challenge->status }}</span>
                    </div>
                    <p class="text-sm text-gray-500">
                        {{ $challenge->start_date->format('d M') }} - {{ $challenge->end_date->format('d M Y') }}
                    </p>
                    <div class="text-sm text-gray-500">
                        {{ $challenge->artworks->count() }} submissions
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada challenge. Mulai buat challenge pertamamu!</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

