@extends('layouts.app')
@section('content')
    <h2>Admin Dashboard</h2>
    <ul>
        <li><a href="{{ route('admin.users.index') }}">Kelola User</a></li>
        <li><a href="{{ route('admin.artworks.index') }}">Moderasi Karya</a></li>
    </ul>
@endsection
