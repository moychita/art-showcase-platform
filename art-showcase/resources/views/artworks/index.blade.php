@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen pb-20">
    <!-- Header Gallery -->
    <div class="bg-gray-50 py-16 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold text-dark mb-4">Galeri Karya</h1>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                Jelajahi ribuan inspirasi visual dari mahasiswa bertalenta. Temukan gaya yang sesuai dengan seleramu.
            </p>
            
            <!-- Search Bar Modern -->
            <div class="mt-8 max-w-xl mx-auto">
                <form action="{{ route('artworks.index') }}" method="GET" class="relative">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="w-full pl-6 pr-12 py-4 rounded-full border-0 shadow-lg shadow-gray-200/50 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6" 
                        placeholder="Cari judul karya, deskripsi, atau nama kreator...">
                    <button type="submit" class="absolute right-2 top-2 h-10 w-10 bg-primary rounded-full flex items-center justify-center text-white hover:bg-blue-600 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
        
        <!-- Filter Categories -->
        <div class="flex flex-wrap justify-center items-center gap-3 mb-12">
            
            <!-- TOMBOL REFRESH (IKON + TEKS) -->
            <a href="{{ route('artworks.index') }}" 
               class="group flex items-center gap-2 px-5 py-2 rounded-full text-sm font-medium transition-all {{ !request('category') && !request('search') ? 'bg-dark text-white shadow-lg' : 'bg-white text-gray-600 border border-gray-200 hover:border-dark hover:text-dark' }}">
                
                <!-- Ikon Refresh (Berputar saat hover) -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-500 group-hover:-rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                
                <!-- Teks Refresh -->
                <span>Refresh</span>
            </a>

            <!-- Daftar Kategori -->
            @foreach($categories as $category)
                <a href="{{ route('artworks.index', array_merge(request()->all(), ['category' => $category->id])) }}" 
                   class="px-6 py-2 rounded-full text-sm font-medium transition-all {{ request('category') == $category->id ? 'bg-dark text-white shadow-lg' : 'bg-white text-gray-600 border border-gray-200 hover:border-dark hover:text-dark' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Grid Karya -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($artworks as $artwork)
                <div class="group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:-translate-y-1">
                    <!-- Image -->
                    <div class="aspect-[4/3] w-full overflow-hidden bg-gray-200 relative">
                        <img src="{{ Storage::url($artwork->media_path) }}" alt="{{ $artwork->title }}" class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                        
                        <!-- Overlay on Hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                            <a href="{{ route('artworks.show', $artwork) }}" class="inline-block bg-white text-dark font-bold text-xs px-4 py-2 rounded-full self-start mb-2 hover:bg-secondary hover:text-white transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 line-clamp-1 group-hover:text-primary transition">
                                    <a href="{{ route('artworks.show', $artwork) }}">{{ $artwork->title }}</a>
                                </h3>
                                <p class="text-sm text-gray-500">by {{ $artwork->user->name }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50">
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                {{ $artwork->category->name ?? 'Art' }}
                            </span>
                            <div class="flex items-center text-gray-400 text-sm gap-3">
                                <span class="flex items-center gap-1 hover:text-red-500 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                    {{ $artwork->likes_count }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    {{ $artwork->views }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada karya ditemukan</h3>
                    <p class="mt-1 text-gray-500">Coba kata kunci lain atau hapus filter kategori.</p>
                    <div class="mt-6">
                        <a href="{{ route('artworks.index') }}" class="text-primary hover:underline font-medium">Reset Filter</a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination Modern -->
        <div class="mt-16">
            {{ $artworks->links() }}
        </div>
    </div>
</div>
@endsection