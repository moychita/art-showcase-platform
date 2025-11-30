@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-dark">Edit Challenge</h1>
                <p class="mt-1 text-gray-500">Perbarui detail kompetisi atau ubah statusnya.</p>
            </div>
            <a href="{{ route('curator.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-dark flex items-center transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('curator.challenges.update', $challenge) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf
                @method('PUT')

                <!-- Upload Banner -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Banner Utama</label>
                    
                    <div id="drop-zone" class="relative mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-solid border-gray-300 rounded-xl hover:border-primary hover:bg-blue-50 transition-all duration-200 cursor-pointer group">
                        
                        <input id="image" name="image" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*" onchange="previewImage(this)">

                        <!-- Placeholder -->
                        <div class="space-y-1 text-center {{ $challenge->image ? 'hidden' : '' }}" id="upload-placeholder">
                            <div class="mx-auto h-12 w-12 text-gray-400 group-hover:text-primary transition">
                                <svg class="mx-auto h-12 w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <span class="relative cursor-pointer rounded-md font-medium text-primary hover:text-blue-600">
                                    Ganti Gambar
                                </span>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah gambar</p>
                        </div>

                        <!-- Preview Container -->
                        <div id="preview-container" class="{{ $challenge->image ? '' : 'hidden' }} absolute inset-0 w-full h-full bg-white rounded-xl flex items-center justify-center z-20 p-2">
                            <img id="preview-img" src="{{ $challenge->image ? Storage::url($challenge->image) : '#' }}" alt="Preview" class="max-h-full max-w-full object-contain rounded-lg">
                            <div class="absolute bottom-3 bg-black/70 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm pointer-events-none">
                                Gambar Saat Ini / Baru
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Fields -->
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-1">Judul Challenge</label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $challenge->title) }}" 
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-bold text-gray-700 mb-1">Status Publikasi</label>
                        <select name="status" id="status" class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm cursor-pointer">
                            <option value="active" {{ $challenge->status == 'active' ? 'selected' : '' }}>🟢 Active (Sedang Berlangsung)</option>
                            <option value="closed" {{ $challenge->status == 'closed' ? 'selected' : '' }}>🔴 Closed (Selesai/Ditutup)</option>
                            <option value="draft" {{ $challenge->status == 'draft' ? 'selected' : '' }}>⚪ Draft (Disembunyikan)</option>
                        </select>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi & Aturan Main</label>
                        <textarea id="description" name="description" rows="6" required 
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">{{ old('description', $challenge->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="start_date" class="block text-sm font-bold text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" required value="{{ old('start_date', $challenge->start_date->format('Y-m-d')) }}"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-bold text-gray-700 mb-1">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" required value="{{ old('end_date', $challenge->end_date->format('Y-m-d')) }}"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                    
                    <!-- TOMBOL HAPUS (Form Terpisah) -->
                    <button type="submit" form="delete-challenge-form" class="text-red-500 hover:text-red-700 text-sm font-bold transition flex items-center gap-1 px-4 py-2 rounded-lg hover:bg-red-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus Challenge
                    </button>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('curator.dashboard') }}" class="px-6 py-3 rounded-full text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold text-white bg-primary hover:bg-blue-600 shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Hidden Delete Form (Fixed Route Name: curator.challenges.destroy) -->
<form id="delete-challenge-form" action="{{ route('curator.challenges.destroy', $challenge) }}" method="POST" class="hidden" onsubmit="return confirm('Apakah Anda yakin ingin menghapus challenge ini secara permanen? Tindakan ini tidak dapat dibatalkan.');">
    @csrf
    @method('DELETE')
</form>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('upload-placeholder').classList.add('hidden');
                document.getElementById('preview-container').classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection