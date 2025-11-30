@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6 border-b pb-4">
        <h1 class="text-2xl font-bold text-gray-900">Koleksi Favorit Saya</h1>
        <p class="text-gray-600 mt-1">Karya-karya inspiratif yang Anda simpan.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($artworks as $artwork)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition group">
                <a href="{{ route('artworks.show', $artwork) }}" class="block relative aspect-w-4 aspect-h-3">
                    <img src="{{ Storage::url($artwork->media_path) }}" alt="{{ $artwork->title }}" class="object-cover w-full h-64 group-hover:opacity-90 transition">
                    <!-- Overlay Info -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-4">
                        <div class="text-white">
                            <p class="font-bold truncate">{{ $artwork->title }}</p>
                            <p class="text-xs opacity-90">by {{ $artwork->user->name }}</p>
                        </div>
                    </div>
                </a>
                <div class="p-4 flex justify-between items-center">
                    <div class="text-xs text-gray-500">
                        Disimpan {{ $artwork->created_at->diffForHumans() }}
                    </div>
                    <!-- Tombol Hapus dari Favorit -->
                    <form action="{{ route('artworks.favorite', $artwork) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-yellow-500 hover:text-yellow-600" title="Hapus dari favorit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada favorit</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai jelajahi galeri dan simpan karya yang Anda sukai.</p>
                <div class="mt-6">
                    <a href="{{ route('artworks.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Jelajahi Galeri
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection