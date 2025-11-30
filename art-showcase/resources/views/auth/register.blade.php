@extends('layouts.app')

@section('content')
<div class="min-h-screen flex bg-gray-50">
    <!-- Sisi Kiri: Info -->
    <div class="hidden lg:flex w-1/2 bg-dark text-white p-12 flex-col justify-between relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-primary opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-secondary opacity-20 blur-3xl"></div>
        
        <div class="relative z-10">
            <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight">ArtShowcase</a>
        </div>
        <div class="relative z-10">
            <h1 class="text-5xl font-extrabold mb-6 leading-tight">Mulai Perjalanan Kreatifmu.</h1>
            <p class="text-lg text-gray-400">Daftar sekarang untuk memamerkan karya, mengikuti kompetisi, dan membangun portofolio profesional.</p>
        </div>
        <div class="relative z-10 text-sm text-gray-500">
            &copy; 2025 Art Showcase Platform
        </div>
    </div>

    <!-- Sisi Kanan: Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-16 bg-white">
        <div class="w-full max-w-md">
            <h2 class="text-3xl font-bold text-dark mb-2">Buat Akun Baru</h2>
            <p class="text-gray-500 mb-8">Lengkapi data diri Anda untuk bergabung.</p>

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent transition" 
                        placeholder="John Doe">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Kampus / Pribadi</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent transition" 
                        placeholder="john@example.com">
                </div>

                <!-- Role Selection (Visual Cards) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Saya mendaftar sebagai:</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="member" class="peer sr-only" checked>
                            <div class="rounded-2xl border-2 border-gray-200 p-4 hover:bg-gray-50 peer-checked:border-primary peer-checked:bg-blue-50 transition-all">
                                <div class="text-2xl mb-1">🎨</div>
                                <div class="font-bold text-dark">Kreator</div>
                                <div class="text-xs text-gray-500">Saya ingin upload karya</div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="curator" class="peer sr-only">
                            <div class="rounded-2xl border-2 border-gray-200 p-4 hover:bg-gray-50 peer-checked:border-purple-500 peer-checked:bg-purple-50 transition-all">
                                <div class="text-2xl mb-1">🏆</div>
                                <div class="font-bold text-dark">Kurator</div>
                                <div class="text-xs text-gray-500">Saya penyelenggara event</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required 
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent transition" 
                            placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi</label>
                        <input type="password" name="password_confirmation" required 
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent transition" 
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 px-6 rounded-full bg-secondary hover:bg-orange-600 text-white font-bold text-lg shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-1">
                        Daftar Sekarang
                    </button>
                </div>

                <p class="text-center text-sm text-gray-500 mt-6">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">Masuk disini</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection