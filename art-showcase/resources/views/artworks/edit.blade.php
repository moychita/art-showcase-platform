@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Edit Karya</h1>
        <a href="{{ route('artworks.show', $artwork) }}" class="text-sm text-indigo-600 hover:underline">Kembali ke detail</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 md:p-8">
        <form action="{{ route('artworks.update', $artwork) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Preview Gambar Saat Ini -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                <div class="bg-gray-100 p-4 rounded-md flex justify-center">
                    <img src="{{ Storage::url($artwork->media_path) }}" class="h-48 object-contain rounded">
                </div>
            </div>

            <!-- Ganti File (Opsional) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ganti Gambar (Opsional)</label>
                <input type="file" name="media" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
            </div>

            <!-- Judul -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Judul Karya</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $artwork->title) }}" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2 border">
            </div>

            <!-- Kategori -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2 border">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $artwork->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Challenge -->
            @if($challenges->count() > 0)
            <div>
                <label for="challenge_id" class="block text-sm font-medium text-purple-900 mb-2">Ikut Challenge?</label>
                <select name="challenge_id" id="challenge_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm p-2 border">
                    <option value="">Tidak mengikuti challenge</option>
                    @foreach($challenges as $challenge)
                        <option value="{{ $challenge->id }}" {{ $artwork->challenge_id == $challenge->id ? 'selected' : '' }}>
                            {{ $challenge->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2 border">{{ old('description', $artwork->description) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('artworks.show', $artwork) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection