@extends('layouts.app')

@section('content')
<div class="min-h-screen flex">
    <!-- Sisi Kiri: Form Login -->
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div class="mb-8">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Selamat Datang Kembali</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-500 transition">
                        Daftar gratis sekarang
                    </a>
                </p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <div class="mt-1">
                        <!-- Ubah placeholder-gray-400 jadi gray-500 biar lebih jelas -->
                        <input id="email" name="email" type="email" autocomplete="email" required 
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent sm:text-sm transition duration-200"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent sm:text-sm transition duration-200"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-600 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-900">Ingat Saya</label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Lupa password?</a>
                    </div>
                </div>

                <div>
                    <!-- PERBAIKAN: Ganti bg-primary jadi bg-blue-600 agar PASTI MUNCUL -->
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-lg text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition-all duration-200 transform hover:-translate-y-0.5">
                        Masuk Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Atau masuk sebagai</span>
                    </div>
                </div>
                <div class="mt-6">
                    <!-- PERBAIKAN: Tombol Back diberi warna background abu-abu (bg-gray-100) biar kelihatan tombolnya -->
                    <a href="{{ route('home') }}" class="w-full inline-flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm bg-gray-100 text-sm font-bold text-gray-700 hover:bg-gray-200 hover:text-gray-900 transition duration-200">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sisi Kanan: Gambar Dekoratif -->
    <div class="hidden lg:block relative w-0 flex-1 bg-gray-900">
        <img class="absolute inset-0 h-full w-full object-cover opacity-80" src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1964&auto=format&fit=crop" alt="Abstract Art">
        <div class="absolute inset-0 bg-blue-900 mix-blend-multiply opacity-60"></div>
        <div class="absolute inset-0 flex items-center justify-center p-12 text-center">
            <div>
                <h2 class="text-4xl font-extrabold text-white mb-4 drop-shadow-lg">Eksplorasi Tanpa Batas.</h2>
                <p class="text-lg text-blue-100 max-w-md mx-auto drop-shadow-md">Bergabung dengan komunitas seni digital terbesar di universitas.</p>
            </div>
        </div>
    </div>
</div>
@endsection