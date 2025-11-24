@extends('layouts.app')

@section('content')
<h2>Tambah Karya Baru</h2>

<form action="{{ route('artworks.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Judul</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Media Path (URL/Path Gambar)</label>
        <input type="text" name="media_path" class="form-control" required>
    </div>
    <button class="btn btn-success">Simpan</button>
    <a href="{{ route('artworks.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
