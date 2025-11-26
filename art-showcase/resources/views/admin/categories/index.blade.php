@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kategori Karya</h1>
            <p class="text-gray-500 mt-1">Atur kategori seperti Fotografi, UI/UX, 3D Art, dan lainnya.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-800">
                ← Kembali
            </a>
            <a href="{{ route('admin.categories.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">
                Tambah Kategori
            </a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr>
                        <td class="px-4 py-4 text-sm font-semibold text-gray-900">{{ $category->name }}</td>
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $category->slug }}</td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ $category->description ?? '-' }}</td>
                        <td class="px-4 py-4 space-x-4">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                  class="inline-block"
                                  onsubmit="return confirm('Hapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">
                            Belum ada kategori.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</div>
@endsection

