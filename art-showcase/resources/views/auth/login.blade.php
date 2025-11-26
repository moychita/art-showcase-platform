@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6 text-center">Masuk ke ArtShowcase</h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" autofocus
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                       required>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="mr-2 rounded">
                    Ingat saya
                </label>
                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800">Lupa password?</a>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                Masuk
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                Daftar sekarang
            </a>
        </p>
    </div>
</div>
@endsection

