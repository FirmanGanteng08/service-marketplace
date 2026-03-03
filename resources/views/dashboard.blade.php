<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - JasaQu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col hidden md:flex z-10 relative h-screen">
        <div class="h-16 flex items-center px-8 border-b border-gray-100 shrink-0">
            <h1 class="text-3xl font-extrabold text-blue-600">JasaQu</h1>
        </div>

        <div class="flex-1 px-4 py-6 overflow-y-auto">
            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 px-4">Menu Dashboard</div>

            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 bg-blue-50 text-blue-600 rounded-xl font-semibold transition-colors">
                    <span class="mr-3">📊</span> Ringkasan
                </a>
                
                @if(auth()->user()->role === 'provider')
                    <a href="#" class="flex items-center px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-blue-600 rounded-xl font-medium transition-colors">
                        <span class="mr-3">📦</span> Kelola Jasa
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-blue-600 rounded-xl font-medium transition-colors">
                        <span class="mr-3">🛒</span> Order Masuk
                    </a>
                @endif

                @if(auth()->user()->role === 'user')
                    <a href="#" class="flex items-center px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-blue-600 rounded-xl font-medium transition-colors">
                        <span class="mr-3">🛍️</span> Riwayat Pesanan
                    </a>
                @endif

                <a href="{{ route('wallet.index') }}" class="flex items-center px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-blue-600 rounded-xl font-medium transition-colors">
                    <span class="mr-3">💳</span> Saldo & Transaksi
                </a>
            </nav>
        </div>

        <div class="p-6 border-t border-gray-100 shrink-0">
            <a href="{{ route('home') }}" class="flex items-center text-gray-500 hover:text-blue-600 font-semibold transition-colors text-sm">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen">
        
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 relative z-50 shrink-0">
            <h2 class="text-xl font-bold text-gray-800 hidden sm:block">Halo, {{ auth()->user()->name }}! 👋</h2>
            <h2 class="text-xl font-bold text-blue-600 sm:hidden">JasaQu</h2>

            <div class="flex items-center space-x-4 ml-auto">
                <span class="text-sm bg-blue-100 text-blue-800 py-1 px-3 rounded-full font-semibold hidden md:inline-block">
                    {{ strtoupper(auth()->user()->role) }}
                </span>
                
                <div class="relative inline-block text-left" id="dashboardDropdown">
                    <button type="button" class="flex items-center focus:outline-none" onclick="document.getElementById('dashDropdownMenu').classList.toggle('hidden');">
                        <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-extrabold border-2 border-white shadow-sm hover:ring-2 hover:ring-blue-300 transition cursor-pointer">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </button>

                    <div id="dashDropdownMenu" class="hidden absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 origin-top-right transition-all">
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition">
                            <span class="mr-3">⚙️</span> Detail Profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-50 mt-2 pt-2">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-5 py-2.5 text-sm text-red-600 hover:bg-red-50 font-bold transition text-left">
                                <span class="mr-3">🚪</span> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 p-8 overflow-y-auto">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-8 flex items-center shadow-sm">
                    <span class="mr-2 text-xl">🎉</span> {{ session('success') }}
                </div>
            @endif

            @if(auth()->user()->role !== 'super_admin')
            <div class="bg-blue-600 rounded-2xl p-8 text-white shadow-lg shadow-blue-200 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] relative overflow-hidden">
                <div class="relative z-10 mb-4 md:mb-0">
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Saldo Dompet</p>
                    <p class="text-4xl font-extrabold tracking-tight">Rp{{ number_format(auth()->user()->wallet->balance ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="relative z-10">
                    <a href="{{ route('wallet.index') }}" class="inline-block bg-white text-blue-600 px-6 py-3 rounded-xl font-bold hover:bg-gray-50 transition shadow-sm text-center">
                        {{ auth()->user()->role === 'user' ? 'Top Up Saldo' : 'Tarik Dana' }}
                    </a>
                </div>
            </div>
            @endif

            @if(auth()->user()->role === 'provider')
                <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Bisnis</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="text-gray-400 text-sm font-semibold mb-2">Total Jasa</div>
                        <div class="text-3xl font-black text-gray-800">{{ auth()->user()->services->count() }}</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="text-gray-400 text-sm font-semibold mb-2">Order Aktif</div>
                        <div class="text-3xl font-black text-blue-600">0</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="text-gray-400 text-sm font-semibold mb-2">Total Pendapatan</div>
                        <div class="text-3xl font-black text-green-500">Rp0</div>
                    </div>
                </div>
            @elseif(auth()->user()->role === 'user')
                <h3 class="text-lg font-bold text-gray-900 mb-4">Aktivitas Terakhir</h3>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
                    <div class="text-5xl mb-4">🛍️</div>
                    <p class="text-gray-500 font-medium">Anda belum memiliki riwayat pesanan yang aktif.</p>
                    <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-50 text-blue-600 px-6 py-3 rounded-xl font-bold hover:bg-blue-100 transition">Cari Jasa Sekarang</a>
                </div>
            @endif

        </div>
    </main>

</body>
</html>