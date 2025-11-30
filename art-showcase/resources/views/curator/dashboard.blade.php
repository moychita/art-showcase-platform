@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Dashboard -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-dark">Dashboard Kurator</h1>
                <p class="mt-1 text-gray-500">Kelola kompetisi dan temukan bakat baru hari ini.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('curator.challenges.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-full shadow-lg text-sm font-bold text-white bg-secondary hover:bg-orange-600 transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Challenge Baru
                </a>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 rounded-xl bg-blue-50 text-primary mr-4">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Challenge</p>
                    <p class="text-2xl font-bold text-dark">{{ $stats['total_challenges'] }}</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 rounded-xl bg-green-50 text-green-600 mr-4">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Sedang Aktif</p>
                    <p class="text-2xl font-bold text-dark">{{ $stats['active_challenges'] }}</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 rounded-xl bg-purple-50 text-purple-600 mr-4">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Submisi</p>
                    <p class="text-2xl font-bold text-dark">{{ $stats['total_submissions'] }}</p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 rounded-xl bg-gray-50 text-gray-600 mr-4">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Selesai</p>
                    <p class="text-2xl font-bold text-dark">{{ $stats['closed_challenges'] }}</p>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Challenge -->
        <div class="bg-white shadow-lg shadow-gray-100 rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-dark">Daftar Challenge Anda</h3>
                <a href="#" class="text-sm font-medium text-primary hover:text-blue-700">Lihat Semua →</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Info Challenge</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Periode</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Partisipan</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($challenges as $challenge)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 bg-gray-200 rounded-lg overflow-hidden">
                                            @if($challenge->image)
                                                <img class="h-10 w-10 object-cover" src="{{ Storage::url($challenge->image) }}" alt="">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-primary text-white font-bold text-xs">
                                                    {{ substr($challenge->title, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-dark">{{ $challenge->title }}</div>
                                            @if($challenge->winner)
                                                <div class="text-xs text-green-600 flex items-center mt-0.5">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    Pemenang Terpilih
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($challenge->status === 'active')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                            Aktif
                                        </span>
                                    @elseif($challenge->status === 'closed')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex flex-col">
                                        <span>{{ $challenge->start_date->format('d M') }} - {{ $challenge->end_date->format('d M Y') }}</span>
                                        <span class="text-xs text-gray-400 mt-0.5">
                                            {{ $challenge->end_date->isPast() ? 'Berakhir' : $challenge->end_date->diffForHumans() }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex -space-x-2 overflow-hidden">
                                        @foreach($challenge->artworks->take(3) as $artwork)
                                            @if($artwork->user->avatar)
                                                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="{{ Storage::url($artwork->user->avatar) }}" alt=""/>
                                            @else
                                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full ring-2 ring-white bg-gray-100 text-xs font-bold">{{ substr($artwork->user->name, 0, 1) }}</span>
                                            @endif
                                        @endforeach
                                        @if($challenge->artworks->count() > 3)
                                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full ring-2 ring-white bg-gray-100 text-xs font-medium text-gray-500">+{{ $challenge->artworks->count() - 3 }}</span>
                                        @endif
                                    </div>
                                    @if($challenge->artworks->count() == 0)
                                        <span class="text-xs italic text-gray-400">Belum ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('curator.challenges.show', $challenge) }}" class="text-primary hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">Detail</a>
                                        <a href="{{ route('curator.challenges.edit', $challenge) }}" class="text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 px-3 py-1.5 rounded-lg transition">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="mx-auto h-12 w-12 text-gray-300 mb-3">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <p class="text-gray-500 text-sm">Belum ada challenge yang Anda buat.</p>
                                    <a href="{{ route('curator.challenges.create') }}" class="text-primary hover:underline text-sm mt-2 inline-block">Mulai buat sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($challenges->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-100 sm:px-6">
                    {{ $challenges->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection