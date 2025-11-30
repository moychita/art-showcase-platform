<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'RupaRupi') }}</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2563EB', // Biru terang
                        secondary: '#F97316', // Oranye
                        dark: '#0F172A',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white text-slate-800 font-sans antialiased selection:bg-primary selection:text-white">

    <!-- Navbar Modern -->
    <nav class="fixed w-full z-50 top-0 start-0 border-b border-gray-100 bg-white/90 backdrop-blur-md transition-all duration-300">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between px-4 py-4">
            
            <!-- Logo RupaRupi -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 rtl:space-x-reverse">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white font-bold text-lg">R</div>
                <span class="self-center text-xl font-bold whitespace-nowrap text-dark tracking-tight">RupaRupi</span>
            </a>

            <!-- Mobile Menu Button -->
            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>

            <!-- Menu Kanan (Auth Buttons) -->
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse gap-2">
                @auth
                    <div class="flex items-center gap-4">
                        <span class="hidden md:block text-sm font-medium text-gray-600">Hi, {{ Auth::user()->name }}</span>
                        
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-white bg-dark hover:bg-gray-800 font-medium rounded-full text-sm px-5 py-2.5 text-center transition">Admin Panel</a>
                        @elseif(Auth::user()->isCurator())
                            <a href="{{ route('curator.dashboard') }}" class="text-white bg-purple-600 hover:bg-purple-700 font-medium rounded-full text-sm px-5 py-2.5 text-center transition">Curator Area</a>
                        @else
                            <a href="{{ route('member.dashboard') }}" class="text-white bg-primary hover:bg-blue-700 font-medium rounded-full text-sm px-5 py-2.5 text-center transition">Dashboard</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-red-600 font-medium">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-dark hover:text-primary font-medium rounded-lg text-sm px-4 py-2 focus:outline-none transition">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="text-white bg-secondary hover:bg-orange-600 font-medium rounded-full text-sm px-6 py-2.5 text-center shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-0.5">
                        Get Started
                    </a>
                @endauth
            </div>

            <!-- Menu Tengah (FIX: Hapus Background Putih/Kotak) -->
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0">
                    <li>
                        <a href="{{ route('home') }}" class="block py-2 px-3 {{ request()->routeIs('home') ? 'text-primary font-bold' : 'text-gray-600 hover:text-primary' }} transition">Beranda</a>
                    </li>
                    <li>
                        <a href="{{ route('artworks.index') }}" class="block py-2 px-3 {{ request()->routeIs('artworks.*') ? 'text-primary font-bold' : 'text-gray-600 hover:text-primary' }} transition">Galeri</a>
                    </li>
                    <li>
                        <a href="{{ route('challenges.index') }}" class="block py-2 px-3 {{ request()->routeIs('challenges.*') ? 'text-primary font-bold' : 'text-gray-600 hover:text-primary' }} transition">Challenge</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="fixed top-24 right-5 z-50 w-full max-w-sm">
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 shadow-lg" role="alert">
                <span class="font-bold">Sukses!</span> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200 shadow-lg" role="alert">
                <span class="font-bold">Error!</span> {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Content -->
    <main class="pt-20 min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white font-bold text-xl mx-auto mb-4">R</div>
            <p class="text-gray-500 mb-4">&copy; {{ date('Y') }} RupaRupi Platform. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>