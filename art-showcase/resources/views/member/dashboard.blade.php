@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard Kreator</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Total Karya</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_artworks'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Total Likes</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_likes'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Total Favorites</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_favorites'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Total Views</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_views'] ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Karya Terbaru</h2>
        <div class="space-y-4">
            @forelse ($recentArtworks as $artwork)
                <div class="border border-gray-100 rounded p-4 flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $artwork->title }}</p>
                        <p class="text-sm text-gray-500">{{ $artwork->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $artwork->likes_count ?? 0 }} suka • {{ $artwork->favorites_count ?? 0 }} favorit
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada karya. Mulai unggah karyamu pertama!</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Favorit Terbaru</h2>
        <div class="space-y-4">
            @forelse ($favoritedArtworks as $artwork)
                <div class="border border-gray-100 rounded p-4 flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $artwork->title }}</p>
                        <p class="text-sm text-gray-500">oleh {{ $artwork->user->name }}</p>
                    </div>
                    <span class="text-xs uppercase text-gray-500">{{ $artwork->category->name ?? 'Tanpa kategori' }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada karya yang disimpan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

