@extends('layouts.app')

@section('content')
<!-- Hero Section Detail -->
<div class="relative bg-dark text-white">
    <div class="absolute inset-0 overflow-hidden">
        @if($challenge->image)
            <img src="{{ Storage::url($challenge->image) }}" class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-t from-dark via-transparent to-transparent"></div>
        @else
            <div class="w-full h-full bg-gradient-to-r from-primary to-blue-900 opacity-90"></div>
        @endif
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 text-center">
        @if($challenge->status === 'active')
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-400 border border-green-500/30 mb-6 backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
                SEDANG BERLANGSUNG
            </span>
        @else
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-700 text-gray-300 border border-gray-600 mb-6">
                TELAH BERAKHIR
            </span>
        @endif

        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-6 drop-shadow-lg">
            {{ $challenge->title }}
        </h1>
        
        <!-- Action Button -->
        @if($challenge->status === 'active')
            @auth
                @if(auth()->user()->isMember())
                    <a href="{{ route('artworks.create', ['challenge_id' => $challenge->id]) }}" class="inline-flex items-center px-8 py-4 rounded-full bg-secondary hover:bg-orange-600 text-white font-bold text-lg shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-1">
                        Ikuti Challenge Ini
                        <svg class="ml-2 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 rounded-full bg-white hover:bg-gray-100 text-dark font-bold text-lg shadow-lg transition">
                    Login untuk Ikutan
                </a>
            @endauth
        @endif
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 -mt-10 relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Sidebar Info (Kiri) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Info Card -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                <h3 class="text-lg font-bold text-dark mb-4 border-b border-gray-100 pb-4">Informasi Penting</h3>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-primary flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Periode</p>
                            <p class="text-dark font-medium">{{ $challenge->start_date->format('d M') }} - {{ $challenge->end_date->format('d M Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-lg bg-orange-50 text-secondary flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Sisa Waktu</p>
                            <p class="text-dark font-medium">
                                {{ $challenge->end_date->isPast() ? 'Sudah Berakhir' : $challenge->end_date->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Partisipan</p>
                            <p class="text-dark font-medium">{{ $submissions->total() }} Orang</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-dark mb-4 border-b border-gray-100 pb-4">Tentang Challenge</h3>
                <div class="prose prose-sm text-gray-600">
                    {!! nl2br(e($challenge->description)) !!}
                </div>
            </div>

            <!-- Winner Box (Only if exists) -->
            @if($challenge->winner)
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-6 border border-yellow-200 text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-200 rounded-full blur-2xl opacity-50 -mr-10 -mt-10"></div>
                    
                    <span class="inline-block bg-yellow-400 text-white text-xs font-bold px-3 py-1 rounded-full mb-4 shadow-sm uppercase tracking-wide">
                        🏆 Pemenang Utama
                    </span>
                    
                    <div class="relative mx-auto w-24 h-24 rounded-2xl overflow-hidden shadow-md mb-4 ring-4 ring-white">
                        <img src="{{ Storage::url($challenge->winner->media_path) }}" class="w-full h-full object-cover">
                    </div>
                    
                    <h4 class="text-lg font-bold text-dark">{{ $challenge->winner->title }}</h4>
                    <p class="text-sm text-gray-500 mb-4">oleh <span class="font-semibold text-dark">{{ $challenge->winner->user->name }}</span></p>
                    
                    <a href="{{ route('artworks.show', $challenge->winner) }}" class="block w-full py-2 bg-white text-yellow-700 font-bold text-xs rounded-lg hover:bg-yellow-100 transition shadow-sm">
                        Lihat Karya
                    </a>
                </div>
            @endif
        </div>

        <!-- Galeri Submisi (Kanan) -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-dark">Galeri Partisipan</h2>
                
                <!-- Filter Dropdown (Visual Only) -->
                <div class="relative">
                    <span class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 font-medium">
                        Terbaru
                    </span>
                </div>
            </div>

            @if($submissions->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($submissions as $artwork)
                        <div class="group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:-translate-y-1">
                            <a href="{{ route('artworks.show', $artwork) }}" class="block relative aspect-[4/3] overflow-hidden bg-gray-100">
                                <img src="{{ Storage::url($artwork->media_path) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                                
                                @if($challenge->winner_id == $artwork->id)
                                    <div class="absolute top-3 right-3 bg-yellow-400 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg flex items-center z-10">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        JUARA
                                    </div>
                                @endif

                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-4">
                                    <p class="text-white font-bold text-lg truncate">{{ $artwork->title }}</p>
                                    <p class="text-gray-300 text-sm">by {{ $artwork->user->name }}</p>
                                </div>
                            </a>
                            
                            <div class="p-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 overflow-hidden ring-2 ring-white">
                                        @if($artwork->user->avatar)
                                            <img src="{{ Storage::url($artwork->user->avatar) }}" class="h-full w-full object-cover">
                                        @else
                                            {{ substr($artwork->user->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <span class="ml-2 text-sm font-medium text-gray-700 truncate max-w-[100px]">{{ $artwork->user->name }}</span>
                                </div>
                                <div class="flex items-center text-gray-400 text-xs gap-3">
                                    <span class="flex items-center"><svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg> {{ $artwork->likes_count }}</span>
                                    <span class="flex items-center"><svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/></svg> {{ $artwork->comments_count }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-12">
                    {{ $submissions->links() }}
                </div>
            @else
                <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
                    <div class="mx-auto w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-medium text-dark">Belum ada karya masuk</h3>
                    <p class="mt-1 text-gray-500 max-w-sm mx-auto">Jadilah yang pertama mengirimkan karya untuk challenge ini!</p>
                    @if($challenge->status === 'active')
                        <a href="{{ route('artworks.create', ['challenge_id' => $challenge->id]) }}" class="inline-block mt-4 text-primary font-bold hover:underline">Submit Sekarang</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection