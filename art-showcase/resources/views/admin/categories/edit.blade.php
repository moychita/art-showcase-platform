@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-600 hover:text-gray-800">
            ← Kembali ke daftar
        </a>
        <h1 class="text-3xl font-bold text-gray-900 mt-2">Edit Kategori</h1>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="4"
                          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                          placeholder="Deskripsi singkat kategori">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

