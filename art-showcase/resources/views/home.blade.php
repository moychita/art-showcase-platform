<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Welcome to ArtShowcase
        </h1>
        <p class="text-xl text-gray-600 mb-8">
            Platform untuk memamerkan karya seni digital kreator
        </p>
        
        @guest
            <div class="space-x-4">
                <a href="{{ route('register') }}" 
                   class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                    Get Started
                </a>
                <a href="{{ route('login') }}" 
                   class="border border-indigo-600 text-indigo-600 px-6 py-3 rounded-lg hover:bg-indigo-50">
                    Login
                </a>
            </div>
        @endguest
    </div>
</div>
@endsection