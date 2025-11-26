<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Showcase Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">
                        ArtShowcase
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-indigo-600">
                                Admin Dashboard
                            </a>
                        @elseif(auth()->user()->isMember())
                            <a href="{{ route('member.dashboard') }}" class="text-gray-700 hover:text-indigo-600">
                                My Dashboard
                            </a>
                        @elseif(auth()->user()->isCurator())
                            <a href="{{ route('curator.dashboard') }}" class="text-gray-700 hover:text-indigo-600">
                                Curator Dashboard
                            </a>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-indigo-600">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Login</a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-indigo-600">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if (session('success'))
            <div class="max-w-4xl mx-auto mt-6 px-4">
                <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-4xl mx-auto mt-6 px-4">
                <div class="bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="max-w-4xl mx-auto mt-6 px-4">
                <div class="bg-yellow-100 border border-yellow-200 text-yellow-800 px-4 py-3 rounded">
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>