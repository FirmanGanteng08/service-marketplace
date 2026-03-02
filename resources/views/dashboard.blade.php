<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - JasaQu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col hidden md:flex">
        <div class="h-16 flex items-center px-8 border-b border-gray-100">
            <h1 class="text-2xl font-extrabold text-blue-600">JasaQu</h1>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="#" class="flex items-center px-4 py-3 bg-blue-50 text-blue-600 rounded-xl font-semibold">
                <span class="mr-3">📊</span> Dashboard
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

            <a href="#" class="flex items-center px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-blue-600 rounded-xl font-medium transition-colors">
                <span class="mr-3">💳</span> Saldo & Transaksi
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl font-medium transition-colors">
                    <span class="mr-3">🚪</span> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen">
        
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8">
            <h2 class="text-xl font-bold text-gray-800">
                Halo, {{ auth()->user()->name }}! 👋
            </h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm bg-blue-100 text-blue-800 py-1 px-3 rounded-full font-semibold">
                    {{ strtoupper(auth()->user()->role) }}
                </span>
                <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold border-2 border-white shadow-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="flex-1 p-8 overflow-y-auto">
            
            @if(auth()->user()->role !== 'super_admin')
            <div class="bg-blue-600 rounded-2xl p-8 text-white shadow-lg shadow-blue-200 mb-8 flex justify-between items-center bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Saldo Dompet</p>
                    <p class="text-4xl font-extrabold tracking-tight">Rp{{ number_format(auth()->user()->wallet->balance ?? 0, 0, ',', '.') }}</p>
                </div>
                <div>
                    @if(auth()->user()->role === 'user')
                        <button class="bg-white text-blue-600 px-6 py-3 rounded-xl font-bold hover:bg-gray-50 transition shadow-sm">Top Up Saldo</button>
                    @elseif(auth()->user()->role === 'provider')
                        <button class="bg-white text-blue-600 px-6 py-3 rounded-xl font-bold hover:bg-gray-50 transition shadow-sm">Tarik Dana</button>
                    @endif
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
                        <div class="text-3xl font-black text-blue-600">2</div>
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
                    <p class="text-gray-500 font-medium">Belum ada pesanan aktif saat ini.</p>
                    <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-50 text-blue-600 px-6 py-2 rounded-lg font-bold hover:bg-blue-100 transition">Cari Jasa Sekarang</a>
                </div>
            @endif

        </div>
    </main>

</body>
</html>