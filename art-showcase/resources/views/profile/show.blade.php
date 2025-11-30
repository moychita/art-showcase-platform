@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
    <div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
    <div class="px-6 pb-6">
        <div class="relative flex items-end -mt-12 mb-4">
            <div class="h-24 w-24 rounded-full ring-4 ring-white bg-gray-200 overflow-hidden">
                @if($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" class="h-full w-full object-cover">
                @else
                    <div class="h-full w-full flex items-center justify-center bg-gray-300 text-gray-500 font-bold text-3xl">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
            </div>
            
            <div class="ml-4 mb-1">
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <span class="capitalize px-2 py-0.5 bg-gray-100 rounded text-xs font-semibold">
                        {{ $user->role }}
                    </span>
                    <span>• Bergabung {{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>

            @if(auth()->id() === $user->id)
                <a href="{{ route('profile.edit') }}" class="ml-auto bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-50 shadow-sm">
                    Edit Profil
                </a>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="col-span-2">
                <h3 class="font-semibold text-gray-900 mb-2">Tentang</h3>
                <p class="text-gray-600 text-sm whitespace-pre-line">
                    {{ $user->bio ?? 'Belum ada deskripsi profil.' }}
                </p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 mb-2">Tautan</h3>
                <div class="space-y-2 text-sm">
                    @php $links = $user->external_links ?? []; @endphp
                    
                    @if(isset($links['website']))
                        <a href="{{ $links['website'] }}" target="_blank" class="flex items-center text-indigo-600 hover:underline">
                            🌐 Website Portfolio
                        </a>
                    @endif
                    @if(isset($links['instagram']))
                        <a href="https://instagram.com/{{ $links['instagram'] }}" target="_blank" class="flex items-center text-pink-600 hover:underline">
                            📸 Instagram
                        </a>
                    @endif
                    @if(isset($links['twitter']))
                        <a href="https://twitter.com/{{ $links['twitter'] }}" target="_blank" class="flex items-center text-blue-400 hover:underline">
                            🐦 Twitter / X
                        </a>
                    @endif

                    @if(empty($links))
                        <p class="text-gray-400 italic">Tidak ada tautan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-6 border-b pb-2">
    <h2 class="text-xl font-bold text-gray-900">Portofolio Karya ({{ $artworks->count() }})</h2>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse($artworks as $artwork)
        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition group">
            <a href="{{ route('artworks.show', $artwork) }}" class="block relative aspect-w-4 aspect-h-3">
                <img src="{{ Storage::url($artwork->media_path) }}" class="object-cover w-full h-48 group-hover:opacity-90 transition">
            </a>
            <div class="p-3">
                <h3 class="font-bold text-gray-900 truncate">{{ $artwork->title }}</h3>
                <p class="text-xs text-gray-500">{{ $artwork->category->name ?? 'Umum' }}</p>
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 text-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
            <p class="text-gray-500">User ini belum mengupload karya apapun.</p>
        </div>
    @endforelse
</div>
@endsection