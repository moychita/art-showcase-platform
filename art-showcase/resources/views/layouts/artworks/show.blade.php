@extends('layouts.app')

@section('content')
<h2>{{ $artwork->title }}</h2>
@if($artwork->media_path)
    <img src="{{ $artwork->media_path }}" alt="{{ $artwork->title }}" class="img-fluid mb-3">
@endif
<p><strong>Deskripsi:</strong> {{ $artwork->description }}</p>
<a href="{{ route('artworks.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
