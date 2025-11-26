@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6 text-center">Daftar Akun Baru</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Daftar sebagai</label>
                <select name="role"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                        required>
                    <option value="member" @selected(old('role') === 'member')>Member / Creator</option>
                    <option value="curator" @selected(old('role') === 'curator')>Curator</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">
                    Curator baru akan masuk status pending hingga admin menyetujui.
                </p>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                Buat Akun
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                Masuk
            </a>
        </p>
    </div>
</div>
@endsection

