<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Rental Car Management') }}</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden relative">
        
        @auth
            @if(Auth::user()->isAdmin())
            <aside id="sidebar" class="w-64 bg-gray-900 text-white shrink-0 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-200 ease-in-out">
                <div class="p-6 border-b border-gray-800 flex justify-between items-center">
                    <h5 class="text-xl font-bold tracking-wide">Rental System</h5>
                    <button id="close-sidebar-btn" class="md:hidden text-gray-400 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <nav class="flex-1 overflow-y-auto py-4">
                    <ul class="space-y-1 px-3">
                        <li>
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 
                               {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                                <i class="fas fa-tachometer-alt w-6 text-center mr-2"></i>
                                <span class="font-medium">Dashboard</span>
                            </a>
                        </li>
                        
                        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Master Data
                        </div>

                        <li>
                            <a href="{{ route('mobils.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('mobils.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                                <i class="fas fa-car w-6 text-center mr-2"></i>
                                <span>Data Mobil</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('jenis_mobils.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('jenis_mobils.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                                <i class="fas fa-tags w-6 text-center mr-2"></i>
                                <span>Jenis Mobil</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('mereks.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('mereks.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                                <i class="fas fa-copyright w-6 text-center mr-2"></i>
                                <span>Merek Mobil</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('supirs.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('supirs.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                                <i class="fas fa-user-tie w-6 text-center mr-2"></i>
                                <span>Data Supir</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('pelanggans.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('pelanggans.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                                <i class="fas fa-users w-6 text-center mr-2"></i>
                                <span>Pelanggan</span>
                            </a>
                        </li>

                        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Transaksi
                        </div>

                        <li>
                            <a href="{{ route('peminjaman.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('peminjaman.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                                <i class="fas fa-calendar-check w-6 text-center mr-2"></i>
                                <span>Peminjaman</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pengembalian.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->routeIs('pengembalian.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                                <i class="fas fa-undo w-6 text-center mr-2"></i>
                                <span>Pengembalian</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>
            @endif
        @endauth

        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

        <div class="flex-1 flex flex-col overflow-hidden relative w-full">
            
            <header class="flex justify-between items-center py-4 px-6 bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center">
                    @auth
                        @if(Auth::user()->isAdmin())
                        <button id="mobile-menu-btn" class="text-gray-500 focus:outline-none md:hidden mr-4 p-2 rounded hover:bg-gray-100">
                            <i class="fas fa-bars fa-lg"></i>
                        </button>
                        @endif
                    @endauth
                    
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <i class="fas fa-car-side text-blue-600 text-2xl"></i>
                        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Rental<span class="text-blue-600">Go</span></h2>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        {{-- Menu User Biasa --}}
                        @if(!Auth::user()->isAdmin())
                            <a href="{{ route('my.rentals') }}" class="text-gray-600 hover:text-blue-600 font-medium px-3 py-2 rounded-lg hover:bg-gray-50 transition">
                                Riwayat Saya
                            </a>
                        @endif

                        {{-- Profil Dropdown Sederhana --}}
                        <div class="relative flex items-center gap-3">
                            <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold uppercase">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            
                            <form action="{{ route('logout') }}" method="POST" class="ml-2">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium" title="Keluar">
                                    <i class="fas fa-sign-out-alt fa-lg"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        {{-- Menu Tamu (Belum Login) --}}
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full font-medium shadow-md transition">Daftar</a>
                    @endauth
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 md:p-6">
                <div class="container mx-auto max-w-7xl">
                    
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm flex justify-between items-center animate-fade-in-down" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-3 text-xl"></i> 
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm flex justify-between items-center animate-fade-in-down" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-3 text-xl"></i> 
                                <span class="font-medium">{{ session('error') }}</span>
                            </div>
                            <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                    
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const closeBtn = document.getElementById('close-sidebar-btn');
            const overlay = document.getElementById('sidebar-overlay');

            if (sidebar && mobileBtn) {
                function toggleSidebar() {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                }

                mobileBtn.addEventListener('click', toggleSidebar);
                if(closeBtn) closeBtn.addEventListener('click', toggleSidebar);
                if(overlay) overlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>
</body>
</html>