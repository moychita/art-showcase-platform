<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>
    
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900">Total Users</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_users'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900">Pending Curators</h3>
            <p class="text-3xl font-bold text-orange-600">{{ $stats['pending_curators'] }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h3>
        <div class="space-x-4">
            <a href="{{ route('admin.users') }}" 
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Manage Users
            </a>
            <a href="{{ route('admin.categories.index') }}" 
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Manage Categories
            </a>
            <a href="{{ route('admin.reports') }}" 
               class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
                Moderation Queue
            </a>
        </div>
    </div>
</div>
@endsection