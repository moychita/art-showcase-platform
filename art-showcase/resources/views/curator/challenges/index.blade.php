@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen pb-20">
    <!-- Hero Header -->
    <div class="relative bg-dark py-20 overflow-hidden">
        <!-- Dekorasi Background -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-primary opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-secondary opacity-20 blur-3xl"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6">Tantangan Kreatif</h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed">
                Asah kemampuanmu, ikuti kompetisi bergengsi, dan menangkan apresiasi dari komunitas serta kurator profesional.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <!-- Grid Challenge -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($challenges as $challenge)
                <div class="group flex flex-col bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 h-full">
                    <!-- Banner Image -->
                    <div class="relative h-56 bg-gray-200 overflow-hidden">
                        @if($challenge->image)
                            <img src="{{ Storage::url($challenge->image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary to-blue-800 text-white text-5xl font-bold">
                                {{ substr($challenge->title, 0, 1) }}
                            </div>
                        @endif
                        
                        <!-- Badge Status -->
                        <div class="absolute top-4 right-4">
                            @if($challenge->status === 'active')
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-green-500 text-white shadow-md">
                                    Sedang Berlangsung
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-gray-600 text-white shadow-md">
                                    Selesai
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-dark mb-2 line-clamp-2 group-hover:text-primary transition">
                                <a href="{{ route('challenges.show', $challenge) }}">
                                    {{ $challenge->title }}
                                </a>
                            </h3>
                            <p class="text-gray-500 text-sm line-clamp-3 leading-relaxed">
                                {{ Str::limit($challenge->description, 120) }}
                            </p>
                        </div>
                        
                        <div class="mt-auto pt-6 border-t border-gray-50">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1.5 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $challenge->end_date->format('d M Y') }}
                                </div>
                                <div class="flex items-center text-sm font-medium text-primary">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $challenge->artworks->count() }} Karya
                                </div>
                            </div>
                            
                            <a href="{{ route('challenges.show', $challenge) }}" class="block w-full py-3 px-4 bg-gray-50 hover:bg-primary hover:text-white text-dark font-semibold text-center rounded-xl transition-colors duration-200">
                                Lihat Detail Challenge
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-dark">Belum ada challenge aktif</h3>
                    <p class="mt-2 text-gray-500">Nantikan kompetisi seru yang akan datang!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $challenges->links() }}
        </div>
    </div>
</div>
@endsection