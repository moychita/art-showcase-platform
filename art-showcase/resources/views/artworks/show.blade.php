@extends('layouts.app')

@section('content')
<!-- Meta CSRF Token untuk AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <!-- Breadcrumb & Navigasi -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('artworks.index') }}" class="text-gray-500 hover:text-primary flex items-center text-sm font-medium transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Galeri
        </a>
        @if(auth()->id() === $artwork->user_id)
            <a href="{{ route('artworks.edit', $artwork) }}" class="text-primary font-bold text-sm hover:underline">
                Edit Karya Ini
            </a>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Gambar Utama (Tengah) -->
        <div class="bg-gray-50 flex justify-center items-center min-h-[400px] p-4 relative group">
            @if($artwork->media_path)
                <img src="{{ Storage::url($artwork->media_path) }}" alt="{{ $artwork->title }}" class="max-h-[70vh] w-auto object-contain rounded-lg shadow-md transition-transform duration-500 group-hover:scale-[1.01]">
            @else
                <div class="flex flex-col items-center text-gray-400">
                    <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Gambar tidak tersedia</span>
                </div>
            @endif
        </div>

        <div class="p-6 md:p-10">
            <div class="flex flex-col lg:flex-row gap-10">
                
                <!-- Kolom Kiri: Informasi Detail -->
                <div class="flex-1">
                    <!-- Meta Info -->
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 bg-blue-50 text-primary text-xs font-bold rounded-full uppercase tracking-wide">
                            {{ $artwork->category->name ?? 'Umum' }}
                        </span>
                        <span class="text-gray-400 text-sm">• {{ $artwork->created_at->format('d M Y') }}</span>
                        <span class="text-gray-400 text-sm flex items-center gap-1 ml-auto lg:ml-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            {{ $artwork->views }} Views
                        </span>
                    </div>

                    <h1 class="text-4xl font-extrabold text-dark mb-6">{{ $artwork->title }}</h1>

                    <!-- Profil Kreator -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl mb-8 border border-gray-100">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-full bg-white border border-gray-200 flex items-center justify-center overflow-hidden">
                                @if($artwork->user->avatar)
                                    <img src="{{ Storage::url($artwork->user->avatar) }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-gray-500 font-bold text-lg">{{ substr($artwork->user->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('profile.show', $artwork->user) }}" class="text-sm font-bold text-gray-900 hover:text-indigo-600 hover:underline">
                                    {{ $artwork->user->name }}
                                </a>
                                <p class="text-xs text-gray-500">Artist / Creator</p>
                            </div>
                        </div>
                        
                        @if(auth()->id() !== $artwork->user_id)
                        <a href="{{ route('profile.show', $artwork->user) }}" class="text-sm font-medium text-primary border border-primary px-4 py-2 rounded-full hover:bg-primary hover:text-white transition">
                            Lihat Profil
                        </a>
                        @endif
                    </div>

                    <div class="prose max-w-none text-gray-600 mb-8">
                        <p>{!! nl2br(e($artwork->description)) !!}</p>
                    </div>
                </div>

                <!-- Sidebar Interaksi -->
                <div class="w-full md:w-72 flex flex-col gap-3">
                    @auth
                        <!-- Tombol Like (AJAX) -->
                        <button onclick="toggleLike({{ $artwork->id }})" id="like-btn" 
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg border-2 transition font-medium {{ $isLiked ? 'border-pink-500 text-pink-600 bg-pink-50' : 'border-gray-200 text-gray-600 hover:border-pink-200' }}">
                            
                            <!-- Ikon Hati -->
                            <svg id="like-icon" class="w-5 h-5 {{ $isLiked ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>

                            <span id="like-text">{{ $isLiked ? 'Disukai' : 'Suka Karya' }}</span>
                            
                            <span id="like-count" class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs ml-1">
                                {{ $artwork->likes_count }}
                            </span>
                        </button>

                        <!-- Tombol Favorite (AJAX) -->
                        <button onclick="toggleFavorite({{ $artwork->id }})" id="fav-btn"
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg border-2 transition font-medium {{ $isFavorited ? 'border-yellow-400 text-yellow-700 bg-yellow-50' : 'border-gray-200 text-gray-600 hover:border-yellow-200' }}">
                            
                            <!-- Ikon Bookmark -->
                            <svg id="fav-icon" class="w-5 h-5 {{ $isFavorited ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            
                            <span id="fav-text">{{ $isFavorited ? 'Tersimpan' : 'Simpan' }}</span>
                        </button>

                        <!-- Tombol Edit (Hanya Pemilik) -->
                        @if(auth()->id() === $artwork->user_id)
                            <a href="{{ route('artworks.edit', $artwork) }}" class="w-full bg-gray-100 text-gray-700 text-center py-3 rounded-lg font-medium hover:bg-gray-200 border border-gray-300 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                Edit Karya
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full bg-indigo-600 text-white text-center py-3 rounded-lg font-medium hover:bg-indigo-700">
                            Login untuk Mengapresiasi
                        </a>
                    @endauth
                    
                    <!-- Tombol Lapor -->
                    @if(auth()->check() && auth()->id() !== $artwork->user_id)
                         <button onclick="document.getElementById('reportModal').classList.remove('hidden')" class="text-xs text-gray-400 hover:text-red-500 text-center mt-2 underline">
                            Laporkan Karya Ini
                        </button>
                    @endif
                </div>
            </div>

            <hr class="my-8 border-gray-100">

            <!-- Kolom Komentar -->
            <div class="max-w-3xl">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Komentar ({{ $artwork->comments_count }})</h3>

                @auth
                    <form action="{{ route('comments.store', $artwork) }}" method="POST" class="mb-8">
                        @csrf
                        <div class="flex gap-4">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex-shrink-0 flex items-center justify-center text-indigo-700 font-bold overflow-hidden">
                                @if(auth()->user()->avatar)
                                    <img src="{{ Storage::url(auth()->user()->avatar) }}" class="h-full w-full object-cover">
                                @else
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                @endif
                            </div>
                            <div class="flex-1">
                                <textarea name="content" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-3 text-sm" placeholder="Tulis apresiasi atau masukanmu..."></textarea>
                                <div class="mt-2 flex justify-end">
                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm font-medium">
                                        Kirim Komentar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endauth

                <div class="space-y-6">
                    @forelse($artwork->comments as $comment)
                        <div class="flex gap-4">
                            <div class="h-10 w-10 rounded-full bg-gray-100 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                @if($comment->user->avatar)
                                    <img src="{{ Storage::url($comment->user->avatar) }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-gray-500 font-bold">{{ substr($comment->user->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="bg-gray-50 p-4 rounded-lg rounded-tl-none">
                                    <div class="flex justify-between items-start mb-1">
                                        <a href="{{ route('profile.show', $comment->user) }}" class="font-bold text-sm text-gray-900 hover:underline">
                                            {{ $comment->user->name }}
                                        </a>
                                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700 text-sm">{{ $comment->content }}</p>
                                </div>
                                <div class="flex items-center gap-3 mt-1 ml-2">
                                    @if(auth()->id() === $comment->user_id || auth()->user()?->isAdmin())
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-xs text-red-500 hover:underline">Hapus</button>
                                        </form>
                                    @endif
                                    
                                    @auth
                                        @if(auth()->id() !== $comment->user_id)
                                            <button type="button" onclick="openReportModal('App\\Models\\Comment', {{ $comment->id }})" class="text-xs text-gray-400 hover:text-red-500 flex items-center gap-1" title="Laporkan Komentar">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8H3zM3 10V5a2 2 0 012-2h14a2 2 0 012 2v5"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10h.01"></path></svg>
                                                Lapor
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm italic">Belum ada komentar. Jadilah yang pertama!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Report -->
<div id="reportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-lg font-bold mb-4" id="reportTitle">Laporkan Konten</h3>
        <form action="{{ route('reports.store') }}" method="POST">
            @csrf
            <input type="hidden" name="reportable_type" id="reportType">
            <input type="hidden" name="reportable_id" id="reportId">
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Alasan</label>
                <select name="reason" class="w-full border rounded p-2">
                    <option value="Spam">Spam / Iklan</option>
                    <option value="Plagiat">Plagiarisme (Hak Cipta)</option>
                    <option value="SARA">Konten SARA / Kebencian</option>
                    <option value="Pornografi">Konten Tidak Pantas</option>
                    <option value="Bullying">Pelecehan / Bullying</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Keterangan Tambahan</label>
                <textarea name="description" class="w-full border rounded p-2" rows="3"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('reportModal').classList.add('hidden')" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Kirim Laporan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Fungsi Modal Laporan
    function openReportModal(type, id) {
        document.getElementById('reportType').value = type;
        document.getElementById('reportId').value = id;
        const title = type.includes('Artwork') ? 'Laporkan Karya' : 'Laporkan Komentar';
        document.getElementById('reportTitle').innerText = title;
        document.getElementById('reportModal').classList.remove('hidden');
    }

    // 1. Fungsi Like (Update Fill Icon & Text tanpa Emoji)
    async function toggleLike(id) {
        const btn = document.getElementById('like-btn');
        const icon = document.getElementById('like-icon'); // Ikon SVG
        const text = document.getElementById('like-text');
        const count = document.getElementById('like-count');

        try {
            const response = await fetch(`/artworks/${id}/like`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken}
            });
            const data = await response.json();

            count.textContent = data.likes_count;

            if (data.liked) {
                // Style AKTIF (Pink)
                btn.classList.remove('border-gray-200', 'text-gray-600', 'hover:border-pink-200');
                btn.classList.add('border-pink-500', 'text-pink-600', 'bg-pink-50');
                
                // Ubah Ikon jadi SOLID (Isi Penuh)
                icon.classList.remove('fill-none');
                icon.classList.add('fill-current');
                
                // Teks Tanpa Emoji
                text.textContent = 'Disukai';
            } else {
                // Style PASIF (Abu-abu)
                btn.classList.add('border-gray-200', 'text-gray-600', 'hover:border-pink-200');
                btn.classList.remove('border-pink-500', 'text-pink-600', 'bg-pink-50');
                
                // Ubah Ikon jadi OUTLINE (Garis)
                icon.classList.add('fill-none');
                icon.classList.remove('fill-current');
                
                // Teks Tanpa Emoji
                text.textContent = 'Suka Karya';
            }
        } catch (error) { alert('Gagal like.'); }
    }

    // 2. Fungsi Favorite (Update Fill Icon & Text tanpa Emoji)
    async function toggleFavorite(id) {
        const btn = document.getElementById('fav-btn');
        const icon = document.getElementById('fav-icon'); // Ikon SVG
        const text = document.getElementById('fav-text');

        try {
            const response = await fetch(`/artworks/${id}/favorite`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken}
            });
            const data = await response.json();

            if (data.favorited) {
                // Style AKTIF (Kuning)
                btn.classList.remove('border-gray-200', 'text-gray-600', 'hover:border-yellow-200');
                btn.classList.add('border-yellow-400', 'text-yellow-700', 'bg-yellow-50');
                
                // Ubah Ikon jadi SOLID
                icon.classList.remove('fill-none');
                icon.classList.add('fill-current');
                
                // Teks Tanpa Emoji
                text.textContent = 'Tersimpan';
            } else {
                // Style PASIF (Abu-abu)
                btn.classList.add('border-gray-200', 'text-gray-600', 'hover:border-yellow-200');
                btn.classList.remove('border-yellow-400', 'text-yellow-700', 'bg-yellow-50');
                
                // Ubah Ikon jadi OUTLINE
                icon.classList.add('fill-none');
                icon.classList.remove('fill-current');
                
                // Teks Tanpa Emoji
                text.textContent = 'Simpan';
            }
        } catch (error) { alert('Gagal favorit.'); }
    }
</script>
@endsection