@extends('layouts.app')

@section('content')
<!-- 1. HERO SECTION (Banner Atas) -->
<div class="relative bg-dark text-white">
    <!-- Background Image -->
    <div class="absolute inset-0 overflow-hidden">
        @if($challenge->image)
            <img src="{{ Storage::url($challenge->image) }}" class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-t from-dark via-transparent to-transparent"></div>
        @else
            <div class="w-full h-full bg-gradient-to-r from-primary to-blue-900 opacity-90"></div>
        @endif
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 text-center">
        <!-- Status Badge -->
        @if($challenge->status === 'active')
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-400 border border-green-500/30 mb-6 backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
                SEDANG BERLANGSUNG
            </span>
        @elseif($challenge->status === 'closed')
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-600/50 text-gray-300 border border-gray-500/30 mb-6 backdrop-blur-sm">
                TELAH BERAKHIR
            </span>
        @endif

        <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight mb-6 drop-shadow-lg">
            {{ $challenge->title }}
        </h1>
        
        <!-- LOGIKA TOMBOL BERDASARKAN ROLE -->
        <div class="flex justify-center gap-4">
            @if($challenge->status === 'active')
                @auth
                    @if(auth()->user()->isMember())
                        <!-- TOMBOL UNTUK MEMBER: SUBMIT -->
                        <a href="{{ route('artworks.create', ['challenge_id' => $challenge->id]) }}" class="inline-flex items-center px-8 py-3 bg-secondary hover:bg-orange-600 text-white font-bold text-lg rounded-full shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-1">
                            Ikuti Challenge Ini
                            <svg class="ml-2 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </a>
                    @elseif(auth()->user()->isCurator() && auth()->id() == $challenge->curator_id)
                        <!-- TOMBOL UNTUK CURATOR: EDIT & TUTUP -->
                        <a href="{{ route('curator.challenges.edit', $challenge) }}" class="inline-flex items-center px-6 py-3 bg-white text-dark font-bold text-sm rounded-full hover:bg-gray-100 transition shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit / Tutup Challenge
                        </a>
                    @endif
                @else
                    <!-- TOMBOL UNTUK GUEST -->
                    <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3 bg-white text-dark font-bold text-lg rounded-full hover:bg-gray-100 transition shadow-lg">
                        Login untuk Ikutan
                    </a>
                @endauth
            @elseif($challenge->status === 'closed')
                <div class="inline-block px-6 py-3 rounded-full bg-gray-800/80 text-gray-300 font-medium border border-gray-700 backdrop-blur-sm">
                    Kompetisi Sudah Ditutup
                </div>
            @endif
        </div>
    </div>
</div>

<!-- 2. MAIN CONTENT (Grid Layout) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 -mt-10 relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI: INFORMASI -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Info Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-dark mb-6">Informasi Penting</h3>
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-primary flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-bold text-gray-400 uppercase">Periode</p>
                            <p class="text-dark font-medium mt-0.5">{{ $challenge->start_date->format('d M') }} - {{ $challenge->end_date->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-lg bg-orange-50 text-secondary flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-bold text-gray-400 uppercase">Sisa Waktu</p>
                            <p class="text-dark font-medium mt-0.5">{{ $challenge->end_date->isPast() ? 'Selesai' : $challenge->end_date->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-dark mb-4 border-b border-gray-100 pb-4">Tentang Challenge</h3>
                <div class="prose prose-sm text-gray-600 leading-relaxed">
                    {!! nl2br(e($challenge->description)) !!}
                </div>
            </div>

            <!-- Pemenang (Jika Ada) -->
            @if($challenge->winner)
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-6 border border-yellow-200 text-center relative overflow-hidden shadow-lg">
                    <span class="inline-block bg-yellow-400 text-white text-[10px] font-bold px-3 py-1 rounded-full mb-4 shadow-sm uppercase tracking-wide">🏆 Pemenang Utama</span>
                    <div class="relative mx-auto w-24 h-24 rounded-xl overflow-hidden shadow-md mb-4 ring-4 ring-white bg-white">
                        <img src="{{ Storage::url($challenge->winner->media_path) }}" class="w-full h-full object-cover">
                    </div>
                    <h4 class="text-lg font-bold text-dark line-clamp-1">{{ $challenge->winner->title }}</h4>
                    <p class="text-sm text-gray-500 mb-4">oleh <span class="font-semibold text-dark">{{ $challenge->winner->user->name }}</span></p>
                    <a href="{{ route('artworks.show', $challenge->winner) }}" class="block w-full py-2 bg-white text-yellow-700 font-bold text-xs rounded-lg hover:bg-yellow-100 transition shadow-sm border border-yellow-100">Lihat Karya Juara</a>
                </div>
            @endif
        </div>

        <!-- KOLOM KANAN: GALERI -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xl font-bold text-gray-900">Submisi Peserta ({{ $submissions->total() }})</h2>
                    @if($submissions->total() > 0)
                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">Terbaru</span>
                    @endif
                </div>

                @if($submissions->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($submissions as $artwork)
                            <div class="group relative bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col hover:-translate-y-1">
                                <a href="{{ route('artworks.show', $artwork) }}" class="block relative aspect-[4/3] bg-gray-100 overflow-hidden">
                                    <img src="{{ Storage::url($artwork->media_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    @if($challenge->winner_id == $artwork->id)
                                        <div class="absolute top-3 right-3 bg-yellow-400 text-white text-xs font-bold px-2 py-1 rounded shadow z-10 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            JUARA
                                        </div>
                                    @endif
                                </a>
                                <div class="p-4">
                                    <h4 class="font-bold text-dark truncate">{{ $artwork->title }}</h4>
                                    <p class="text-xs text-gray-500">by {{ $artwork->user->name }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8">{{ $submissions->links() }}</div>
                @else
                    <div class="text-center py-16 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada karya masuk.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection