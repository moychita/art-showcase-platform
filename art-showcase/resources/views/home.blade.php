@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-white overflow-hidden pb-12 pt-8 lg:pb-24 lg:pt-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Content (Text) -->
            <div class="lg:col-span-6 text-center lg:text-left">
                <div class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-sm font-medium text-primary mb-6 ring-1 ring-inset ring-blue-700/10">
                    <span class="flex h-2 w-2 rounded-full bg-primary mr-2"></span>
                    Platform Seni #1 Universitas Hasanuddin
                </div>
                <h1 class="text-4xl font-extrabold tracking-tight text-dark sm:text-5xl md:text-6xl lg:leading-tight mb-6">
                    Pamerkan <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-purple-600">Karya Seni</span> <br> Kepada Dunia.
                </h1>
                <p class="mx-auto lg:mx-0 max-w-lg text-lg text-gray-500 mb-8 leading-relaxed">
                    Wadah eksklusif bagi mahasiswa untuk membangun portofolio, mengikuti kompetisi bergengsi, dan terhubung dengan kurator profesional.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-secondary px-8 py-4 text-base font-semibold text-white shadow-lg shadow-orange-500/30 hover:bg-orange-600 hover:-translate-y-1 transition-all duration-200">
                        Mulai Berkarya
                        <svg class="ml-2 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </a>
                    <a href="{{ route('artworks.index') }}" class="inline-flex items-center justify-center rounded-full bg-white px-8 py-4 text-base font-semibold text-dark ring-1 ring-gray-200 hover:bg-gray-50 hover:ring-gray-300 transition-all duration-200">
                        Lihat Galeri
                    </a>
                </div>

                <!-- Stats Simple -->
                <div class="mt-12 pt-8 border-t border-gray-100 flex justify-center lg:justify-start gap-8 sm:gap-12">
                    <div>
                        <p class="text-3xl font-bold text-dark">500+</p>
                        <p class="text-sm text-gray-500 mt-1">Karya Seni</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-dark">120+</p>
                        <p class="text-sm text-gray-500 mt-1">Kreator</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-dark">15+</p>
                        <p class="text-sm text-gray-500 mt-1">Challenge</p>
                    </div>
                </div>
            </div>

            <!-- Right Content (Visual Grid - Abstract Gradients) -->
            <div class="lg:col-span-6 relative hidden lg:block">
                <!-- Decorative Blur -->
                <div class="absolute -top-12 -right-12 w-72 h-72 bg-blue-100 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
                <div class="absolute -bottom-12 -left-12 w-72 h-72 bg-orange-100 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Column 1 -->
                    <div class="space-y-4 pt-12">
                        <!-- Art 1: Gradient Biru-Ungu -->
                        <div class="relative overflow-hidden rounded-2xl shadow-lg aspect-[3/4] group">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 transition duration-500 group-hover:scale-110"></div>
                            <!-- Pola Dekoratif -->
                            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                                <span class="text-white font-medium text-sm">Abstract Flow</span>
                            </div>
                        </div>
                        
                        <!-- Art 2: Gradient Orange-Merah -->
                        <div class="relative overflow-hidden rounded-2xl shadow-lg aspect-square group">
                            <div class="absolute inset-0 bg-gradient-to-tr from-orange-400 to-pink-600 transition duration-500 group-hover:scale-110"></div>
                            <div class="absolute inset-0 flex items-center justify-center opacity-30">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Column 2 -->
                    <div class="space-y-4">
                        <!-- Art 3: Gradient Hijau-Teal -->
                        <div class="relative overflow-hidden rounded-2xl shadow-lg aspect-square group">
                            <div class="absolute inset-0 bg-gradient-to-bl from-emerald-400 to-cyan-600 transition duration-500 group-hover:scale-110"></div>
                             <div class="absolute top-0 right-0 p-4 opacity-30">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                            </div>
                        </div>
                        
                        <!-- Art 4: Gradient Pink-Gelap -->
                        <div class="relative overflow-hidden rounded-2xl shadow-lg aspect-[3/4] group">
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-800 to-fuchsia-500 transition duration-500 group-hover:scale-110"></div>
                            <!-- Garis-garis -->
                            <div class="absolute inset-0 opacity-10" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, #fff 10px, #fff 11px);"></div>
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                                <span class="text-white font-medium text-sm">Modern Vibes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gray-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold tracking-tight text-dark sm:text-4xl">Platform Untuk Kreator Masa Depan</h2>
            <p class="mt-4 text-lg text-gray-500">Kembangkan bakatmu dengan fitur-fitur yang mendukung kreativitas.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 group">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition duration-300">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-dark mb-3">Portfolio Showcase</h3>
                <p class="text-gray-500 leading-relaxed">Unggah karya terbaikmu dalam resolusi tinggi. Kategorikan sesuai minat dan bangun reputasi.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 group">
                <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-secondary mb-6 group-hover:scale-110 transition duration-300">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-dark mb-3">Exciting Challenges</h3>
                <p class="text-gray-500 leading-relaxed">Ikuti kompetisi mingguan yang dikurasi oleh ahli. Menangkan hadiah dan sorotan komunitas.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 group">
                <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 mb-6 group-hover:scale-110 transition duration-300">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-dark mb-3">Connect & Grow</h3>
                <p class="text-gray-500 leading-relaxed">Berinteraksi dengan sesama kreator melalui komentar, likes, dan fitur favorit.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-dark px-6 py-20 shadow-2xl sm:px-12 sm:py-24 md:px-16 lg:px-24">
            <div class="absolute -top-24 -left-24 h-96 w-96 rounded-full bg-primary opacity-20 blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-secondary opacity-20 blur-3xl"></div>
            
            <div class="relative max-w-2xl mx-auto text-center">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Siap Menampilkan Karyamu?</h2>
                <p class="mx-auto mt-6 text-lg text-gray-300">
                    Bergabunglah dengan ratusan mahasiswa lainnya. Gratis dan terbuka untuk semua angkatan.
                </p>
                <div class="mt-10 flex justify-center gap-4">
                    <a href="{{ route('register') }}" class="rounded-full bg-secondary px-8 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-all">Daftar Sekarang</a>
                    <a href="{{ route('challenges.index') }}" class="text-sm font-semibold leading-6 text-white px-8 py-3.5 flex items-center hover:text-gray-200 transition">
                        Lihat Challenge <span aria-hidden="true" class="ml-2">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection