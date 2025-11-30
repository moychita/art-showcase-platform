@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan Profil</h1>
        <a href="{{ route('profile.show', $user) }}" class="text-indigo-600 hover:underline text-sm">
            ← Lihat Profil Saya
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-full bg-gray-200 overflow-hidden">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-gray-500 font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <input type="file" name="avatar" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tampilan</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bio / Deskripsi Singkat</label>
                <textarea name="bio" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border p-2" placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <hr class="border-gray-100">

            <div>
                <h3 class="text-md font-medium text-gray-900 mb-3">Tautan Eksternal</h3>
                @php $links = $user->external_links ?? []; @endphp
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Username Instagram (tanpa @)</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">instagram.com/</span>
                            <input type="text" name="instagram" value="{{ old('instagram', $links['instagram'] ?? '') }}" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 border focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Username Twitter / X</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">x.com/</span>
                            <input type="text" name="twitter" value="{{ old('twitter', $links['twitter'] ?? '') }}" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 border focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Website Pribadi / Portfolio</label>
                        <input type="url" name="website" value="{{ old('website', $links['website'] ?? '') }}" placeholder="https://..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border p-2 text-sm">
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 font-medium">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection