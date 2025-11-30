@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-dark">Admin Dashboard</h1>
            <p class="mt-1 text-gray-500">Ringkasan aktivitas dan tindakan cepat.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Total Users -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide">Total Users</h3>
                <div class="mt-2 flex items-baseline">
                    <p class="text-4xl font-extrabold text-primary">{{ $stats['total_users'] }}</p>
                </div>
            </div>

            <!-- Pending Curators -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide">Pending Curators</h3>
                <div class="mt-2 flex items-baseline">
                    <p class="text-4xl font-extrabold text-secondary">{{ $stats['pending_curators'] }}</p>
                    @if($stats['pending_curators'] > 0)
                        <span class="ml-2 text-sm text-gray-400">Menunggu persetujuan</span>
                    @endif
                </div>
            </div>

             <!-- Total Artworks -->
             <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide">Total Karya</h3>
                <div class="mt-2 flex items-baseline">
                    <p class="text-4xl font-extrabold text-green-600">{{ $stats['total_artworks'] }}</p>
                </div>
            </div>

            <!-- Pending Reports -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide">Laporan Masuk</h3>
                <div class="mt-2 flex items-baseline">
                    <p class="text-4xl font-extrabold text-red-600">{{ $stats['pending_reports'] }}</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-12">
            <h2 class="text-lg font-bold text-dark mb-6">Quick Actions</h2>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('admin.users') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-primary text-white font-bold text-sm hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                    Manage Users
                </a>
                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-green-600 text-white font-bold text-sm hover:bg-green-700 transition shadow-lg shadow-green-500/30">
                    Manage Categories
                </a>
                <a href="{{ route('admin.reports') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-secondary text-white font-bold text-sm hover:bg-orange-600 transition shadow-lg shadow-orange-500/30">
                    Moderation Queue
                </a>
            </div>
        </div>

        <!-- Pending Approvals Section (Tabel Data) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Tabel Pending Curators -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-dark">Permintaan Curator</h3>
                    @if($stats['pending_curators'] > 0)
                        <span class="bg-secondary text-white text-xs px-2 py-1 rounded-full font-bold">{{ $stats['pending_curators'] }}</span>
                    @endif
                </div>
                
                <div class="divide-y divide-gray-100">
                    @forelse($pendingCurators as $curator)
                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold mr-3">
                                    {{ substr($curator->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-dark">{{ $curator->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $curator->email }}</p>
                                </div>
                            </div>
                            <form action="{{ route('admin.users.update', $curator) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="role" value="curator">
                                <input type="hidden" name="status" value="active">
                                <button type="submit" class="text-xs bg-primary text-white px-3 py-1.5 rounded-lg font-bold hover:bg-blue-700 transition">
                                    Approve
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-400 text-sm">
                            Tidak ada permintaan pending.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Tabel Pending Artworks -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-dark">Karya Menunggu Moderasi</h3>
                    @if($stats['pending_artworks'] > 0)
                        <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full font-bold">{{ $stats['pending_artworks'] }}</span>
                    @endif
                </div>
                
                <div class="divide-y divide-gray-100">
                    @forelse($pendingArtworks as $artwork)
                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-lg bg-gray-200 overflow-hidden mr-3">
                                    <img src="{{ Storage::url($artwork->media_path) }}" class="h-full w-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-dark truncate w-32">{{ $artwork->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $artwork->user->name }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('admin.artworks.moderate', $artwork) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="text-xs bg-green-500 text-white px-3 py-1.5 rounded-lg font-bold hover:bg-green-600 transition">
                                        ✓
                                    </button>
                                </form>
                                <form action="{{ route('admin.artworks.moderate', $artwork) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="text-xs bg-red-500 text-white px-3 py-1.5 rounded-lg font-bold hover:bg-red-600 transition">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-400 text-sm">
                            Tidak ada karya pending.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection