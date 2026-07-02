<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Souk') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Flowbite CSS (CDN for immediate results) --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet">
</head>
<body class="h-full bg-gray-50">
    {{-- Navbar --}}
    <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 shadow-sm">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <a href="{{ route('home') }}" class="flex items-center">
                <span class="self-center text-xl font-semibold whitespace-nowrap text-blue-700">🛍️ Souk</span>
            </a>
            <div class="flex items-center gap-3">
                @auth
    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('seller.dashboard') }}" 
       class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2">
        Dashboard
    </a>
@else
    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-700 text-sm font-medium">Seller Login</a>
    <a href="{{ route('register') }}" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2">Start Selling</a>
@endauth
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <main class="max-w-screen-xl mx-auto px-4 py-8">
        {{ $slot }}
    </main>

    {{-- Flowbite JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>