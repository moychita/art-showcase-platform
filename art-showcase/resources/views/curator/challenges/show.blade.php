@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Navigasi -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('curator.dashboard') }}" class="hover:text-primary">Dashboard</a>
                    <span>/</span>
                    <span>Detail Challenge</span>
                </div>
                <h1 class="text-3xl font-extrabold text-dark">{{ $challenge->title }}</h1>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('curator.challenges.edit', $challenge) }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-bold hover:bg-gray-50 transition text-sm">
                    Edit Challenge
                </a>
                @if($challenge->status === 'active')
                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-lg font-bold text-sm border border-green-200">
                        Sedang Aktif
                    </span>
                @else
                    <span class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg font-bold text-sm border border-gray-200">
                        {{ ucfirst($challenge->status) }}
                    </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Kiri: Info Challenge -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Card Pemenang (Jika Sudah Ada) -->
                @if($challenge->winner)
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-6 border border-yellow-200 text-center relative overflow-hidden shadow-sm">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-200 rounded-full blur-2xl opacity-50 -mr-10 -mt-10"></div>
                        <span class="inline-block bg-yellow-400 text-white text-[10px] font-bold px-3 py-1 rounded-full mb-4 uppercase tracking-wide">
                            🏆 Pemenang Terpilih
                        </span>
                        <div class="relative mx-auto w-24 h-24 rounded-xl overflow-hidden shadow-md mb-3 ring-4 ring-white bg-white">
                            <img src="{{ Storage::url($challenge->winner->media_path) }}" class="w-full h-full object-cover">
                        </div>
                        <h4 class="text-lg font-bold text-dark line-clamp-1">{{ $challenge->winner->title }}</h4>
                        <p class="text-sm text-gray-500 mb-2">oleh <span class="font-semibold">{{ $challenge->winner->user->name }}</span></p>
                    </div>
                @endif

                <!-- Info Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-dark mb-4 pb-2 border-b border-gray-100">Detail</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase">Periode</p>
                            <p class="text-sm font-medium text-dark">
                                {{ $challenge->start_date->format('d M') }} - {{ $challenge->end_date->format('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase">Sisa Waktu</p>
                            <p class="text-sm font-medium text-dark">
                                {{ $challenge->end_date->isPast() ? 'Sudah Berakhir' : $challenge->end_date->diffForHumans() }}
                            </p>
                        </div>
                         <div>
                            <p class="text-xs text-gray-400 font-bold uppercase">Deskripsi</p>
                            <div class="text-sm text-gray-600 mt-1 prose prose-sm">
                                {!! nl2br(e($challenge->description)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kanan: Daftar Submisi (Untuk Memilih Pemenang) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-dark">Submisi Peserta ({{ $submissions->total() }})</h2>
                        @if(!$challenge->winner && $submissions->count() > 0)
                            <span class="text-xs bg-blue-50 text-primary px-3 py-1 rounded-full font-medium">
                                Silakan pilih pemenang
                            </span>
                        @endif
                    </div>

                    @if($submissions->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($submissions as $artwork)
                                <div class="group relative bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-md transition-all {{ $challenge->winner_id == $artwork->id ? 'ring-2 ring-yellow-400' : '' }}">
                                    <!-- Gambar -->
                                    <a href="{{ route('artworks.show', $artwork) }}" target="_blank" class="block relative aspect-[4/3] bg-gray-100">
                                        <img src="{{ Storage::url($artwork->media_path) }}" class="w-full h-full object-cover">
                                        
                                        @if($challenge->winner_id == $artwork->id)
                                            <div class="absolute top-2 right-2 bg-yellow-400 text-white text-[10px] font-bold px-2 py-1 rounded shadow">JUARA</div>
                                        @endif
                                    </a>

                                    <!-- Info & Tombol Pilih -->
                                    <div class="p-4">
                                        <h4 class="font-bold text-dark truncate">{{ $artwork->title }}</h4>
                                        <p class="text-xs text-gray-500 mb-4">by {{ $artwork->user->name }}</p>
                                        
                                        <!-- Logic Tombol Pilih Pemenang -->
                                        @if(!$challenge->winner_artwork_id)
                                            <form action="{{ route('curator.challenges.selectWinner', $challenge) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin memilih karya ini sebagai pemenang? Challenge akan otomatis ditutup.');">
                                                @csrf
                                                <input type="hidden" name="winner_artwork_id" value="{{ $artwork->id }}">
                                                <button type="submit" class="w-full py-2 rounded-lg bg-gray-50 text-gray-600 text-xs font-bold hover:bg-yellow-400 hover:text-white transition flex items-center justify-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                                                    Pilih Sebagai Juara
                                                </button>
                                            </form>
                                        @elseif($challenge->winner_artwork_id == $artwork->id)
                                            <div class="w-full py-2 rounded-lg bg-yellow-50 text-yellow-700 text-xs font-bold text-center border border-yellow-100">
                                                Terpilih Sebagai Juara
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $submissions->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="text-gray-500 text-sm">Belum ada karya yang disubmit.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection