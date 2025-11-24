@extends('layouts.app')

@section('content')
<h2>Edit Karya</h2>

<form action="{{ route('artworks.update', $artwork) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Judul</label>
        <input type="text" name="title" class="form-control" value="{{ $artwork->title }}" required>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control">{{ $artwork->description }}</textarea>
    </div>
    <div class="mb-3">
        <label>Media Path (URL/Path Gambar)</label>
        <input type="text" name="media_path" class="form-control" value="{{ $artwork->media_path }}" required>
    </div>
    <button class="btn btn-success">Update</button>
    <a href="{{ route('artworks.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
