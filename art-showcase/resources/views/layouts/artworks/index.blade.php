@extends('layouts.app')

@section('content')
<h2>Daftar Karya</h2>

<a href="{{ route('artworks.create') }}" class="btn btn-primary mb-3">Tambah Karya</a>

<table class="table table-bordered">
    <tr>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
    </tr>
    @foreach($artworks as $artwork)
    <tr>
        <td>{{ $artwork->title }}</td>
        <td>{{ $artwork->description }}</td>
        <td>
            <a href="{{ route('artworks.show', $artwork) }}" class="btn btn-info btn-sm">Detail</a>
            <a href="{{ route('artworks.edit', $artwork) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('artworks.destroy', $artwork) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
