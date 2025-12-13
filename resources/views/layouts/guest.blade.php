<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Rental Car') }} - Masuk</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="mb-6">
            <a href="/" class="flex items-center gap-2 group decoration-none">
                <div class="bg-blue-600 text-white p-3 rounded-xl shadow-lg group-hover:bg-blue-700 transition transform group-hover:scale-105">
                    <i class="fas fa-car-side text-2xl"></i>
                </div>
                <span class="text-2xl font-bold text-gray-800 tracking-tight ml-2">Rental<span class="text-blue-600">Go</span></span>
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-2 px-8 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100">
            @yield('content')
        </div>
        
        <div class="mt-8 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} Rental Car Management
        </div>
    </div>
</body>
</html>