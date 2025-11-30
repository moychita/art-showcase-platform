@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Karya Saya</h1>
        <a href="{{ route('artworks.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">
            + Upload Baru
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Karya</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statistik</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($artworks as $artwork)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-12 w-12 flex-shrink-0">
                                    <img class="h-12 w-12 rounded object-cover" src="{{ Storage::url($artwork->media_path) }}" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $artwork->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $artwork->category->name ?? 'Uncategorized' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex gap-3">
                                <span>👁️ {{ $artwork->views }}</span>
                                <span>❤️ {{ $artwork->likes_count }}</span>
                                <span>💬 {{ $artwork->comments_count }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $artwork->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                   ($artwork->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($artwork->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $artwork->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('artworks.show', $artwork) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Lihat</a>
                            <a href="{{ route('artworks.edit', $artwork) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <form action="{{ route('artworks.destroy', $artwork) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus karya ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">
                            Anda belum mengupload karya apapun.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $artworks->links() }}
    </div>
</div>
@endsection