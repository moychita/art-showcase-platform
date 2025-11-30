@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-dark">Upload Karya Baru</h1>
            <p class="mt-1 text-gray-500">Bagikan kreativitasmu kepada dunia.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('artworks.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf

                <!-- Area Upload Gambar (Drag & Drop + Select) -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">File Karya</label>
                    
                    <!-- Drop Zone Container -->
                    <div id="drop-zone" class="relative mt-1 flex justify-center px-6 pt-10 pb-10 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary hover:bg-blue-50 transition-all duration-200 cursor-pointer group">
                        
                        <!-- Input File (Hidden but clickable via label) -->
                        <input id="media" name="media" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*" onchange="handleFiles(this.files)">

                        <!-- Placeholder Content (Initial State) -->
                        <div class="space-y-2 text-center transition-opacity duration-300" id="upload-placeholder">
                            <div class="mx-auto h-16 w-16 text-gray-400 group-hover:text-primary transition bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <span class="relative rounded-md font-bold text-primary hover:text-blue-600 focus-within:outline-none">
                                    Pilih Gambar
                                </span>
                                <p class="pl-1">atau tarik file ke sini</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, WEBP hingga 10MB</p>
                        </div>

                        <!-- Preview Container (Hidden by default) -->
                        <div id="preview-container" class="hidden absolute inset-0 w-full h-full bg-white rounded-xl flex items-center justify-center p-2 z-20">
                            <img id="preview-img" src="#" alt="Preview" class="max-h-full max-w-full object-contain rounded-lg shadow-sm">
                            
                            <!-- Tombol Hapus/Ganti -->
                            <button type="button" onclick="removeImage(event)" class="absolute top-4 right-4 bg-white text-red-500 rounded-full p-2 hover:bg-red-50 transition shadow-md border border-gray-100 z-30" title="Hapus gambar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Info Karya -->
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-1">Judul Karya</label>
                        <input type="text" name="title" id="title" required value="{{ old('title') }}" 
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm placeholder-gray-400"
                            placeholder="Berikan judul yang menarik...">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="category_id" class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                            <select name="category_id" id="category_id" class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                                <option value="">Pilih Kategori...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Challenge Selection (Auto Select Logic) -->
                        <div>
                            <label for="challenge_id" class="block text-sm font-bold text-purple-700 mb-1">Ikut Challenge? (Opsional)</label>
                            <div class="relative">
                                <select name="challenge_id" id="challenge_id" class="block w-full px-4 py-3 rounded-xl border-purple-200 bg-purple-50 text-purple-900 shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                    <option value="">Tidak mengikuti challenge</option>
                                    @foreach($challenges as $challenge)
                                        <option value="{{ $challenge->id }}" 
                                            {{ (request('challenge_id') == $challenge->id || old('challenge_id') == $challenge->id) ? 'selected' : '' }}>
                                            🏆 {{ $challenge->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if(request('challenge_id'))
                                <p class="text-xs text-purple-600 mt-1">*Challenge otomatis terpilih dari halaman sebelumnya.</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi / Cerita</label>
                        <textarea name="description" id="description" rows="4" 
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm placeholder-gray-400"
                            placeholder="Ceritakan makna dibalik karyamu...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                    <a href="{{ route('member.dashboard') }}" class="px-6 py-3 rounded-full text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold text-white bg-primary hover:bg-blue-600 shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                        Upload Karya
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    // --- JAVASCRIPT DRAG & DROP LOGIC ---
    
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('media');
    const previewContainer = document.getElementById('preview-container');
    const previewImg = document.getElementById('preview-img');
    const placeholder = document.getElementById('upload-placeholder');

    // 1. Handle File Selection (Click or Drop)
    function handleFiles(files) {
        if (files.length > 0) {
            const file = files[0];
            
            // Validasi tipe file (harus gambar)
            if (!file.type.startsWith('image/')) {
                alert('Harap upload file gambar.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                placeholder.classList.add('hidden'); // Sembunyikan placeholder text
                previewContainer.classList.remove('hidden'); // Tampilkan gambar
                
                // Style visual saat ada gambar
                dropZone.classList.remove('border-dashed', 'border-gray-300');
                dropZone.classList.add('border-solid', 'border-primary');
            }
            reader.readAsDataURL(file);
        }
    }

    // 2. Handle Remove Image Button
    function removeImage(event) {
        // Mencegah trigger klik ke input file di bawahnya
        event.preventDefault(); 
        event.stopPropagation(); 

        fileInput.value = ''; // Reset nilai input
        previewImg.src = '#';
        
        // Kembalikan tampilan awal
        previewContainer.classList.add('hidden');
        placeholder.classList.remove('hidden');
        
        dropZone.classList.add('border-dashed', 'border-gray-300');
        dropZone.classList.remove('border-solid', 'border-primary');
    }

    // 3. Drag & Drop Event Listeners
    
    // Mencegah perilaku default browser (membuka file di tab baru)
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Visual Feedback saat file ditarik ke dalam area (Highlight)
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.add('bg-blue-100', 'border-primary', 'scale-[1.02]');
        }, false);
    });

    // Hapus feedback saat file keluar atau didrop
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.remove('bg-blue-100', 'border-primary', 'scale-[1.02]');
        }, false);
    });

    // Handle Drop Event yang sebenarnya
    dropZone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;

        // Masukkan file yang didrop ke dalam input element agar terkirim saat form disubmit
        fileInput.files = files;
        
        // Panggil fungsi preview
        handleFiles(files);
    });
</script>
@endsection