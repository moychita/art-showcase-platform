@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-dark">Buat Challenge Baru</h1>
                <p class="mt-1 text-gray-500">Mulai kompetisi baru dan temukan talenta terbaik.</p>
            </div>
            <a href="{{ route('curator.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-dark flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('curator.challenges.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf

                <!-- Upload Banner (Berfungsi) -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Banner Utama</label>
                    
                    <!-- Drop Zone -->
                    <div id="drop-zone" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary hover:bg-blue-50 transition cursor-pointer group relative">
                        
                        <div class="space-y-1 text-center" id="upload-placeholder">
                            <div class="mx-auto h-12 w-12 text-gray-400 group-hover:text-primary transition">
                                <svg class="mx-auto h-12 w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="image" class="relative cursor-pointer rounded-md font-medium text-primary hover:text-blue-600 focus-within:outline-none">
                                    <span>Upload gambar</span>
                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 5MB</p>
                        </div>

                        <!-- Preview Container (Hidden by default) -->
                        <div id="preview-container" class="hidden absolute inset-0 w-full h-full bg-white rounded-xl flex items-center justify-center">
                            <img id="preview-img" src="#" alt="Preview" class="max-h-full max-w-full object-contain rounded-xl">
                            <button type="button" onclick="removeImage()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Detail Challenge -->
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-1">Judul Challenge</label>
                        <input type="text" name="title" id="title" required value="{{ old('title') }}" 
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                            placeholder="Contoh: Fotografi Senja Kampus">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi & Aturan Main</label>
                        <textarea id="description" name="description" rows="5" required 
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                            placeholder="Jelaskan tema, syarat, dan kriteria penilaian..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="start_date" class="block text-sm font-bold text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" required value="{{ old('start_date') }}"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-bold text-gray-700 mb-1">Tanggal Selesai (Deadline)</label>
                            <input type="date" name="end_date" id="end_date" required value="{{ old('end_date') }}"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                    <a href="{{ route('curator.dashboard') }}" class="px-6 py-3 rounded-full text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold text-white bg-secondary hover:bg-orange-600 shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-0.5">
                        Terbitkan Challenge
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('image');
    const placeholder = document.getElementById('upload-placeholder');
    const previewContainer = document.getElementById('preview-container');
    const previewImg = document.getElementById('preview-img');

    // Handle File Selection via Click
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                placeholder.classList.add('hidden');
                previewContainer.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Handle Remove Image
    function removeImage() {
        fileInput.value = ''; // Reset input
        previewImg.src = '#';
        previewContainer.classList.add('hidden');
        placeholder.classList.remove('hidden');
    }

    // Handle Drag & Drop Events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight drop zone
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.add('border-primary', 'bg-blue-50');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.remove('border-primary', 'bg-blue-50');
        }, false);
    });

    // Handle File Drop
    dropZone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            fileInput.files = files; // Assign dropped files to input
            previewImage(fileInput); // Trigger preview
        }
    });
</script>
@endsection