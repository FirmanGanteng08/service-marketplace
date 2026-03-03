<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saldo & Transaksi - JasaQu</title>
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
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-blue-600 rounded-xl font-medium transition-colors">
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

                <a href="{{ route('wallet.index') }}" class="flex items-center px-4 py-3 bg-blue-50 text-blue-600 rounded-xl font-semibold transition-colors">
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
            <h2 class="text-xl font-bold text-gray-800 hidden sm:block">Saldo & Transaksi</h2>
            <h2 class="text-xl font-bold text-blue-600 sm:hidden">JasaQu</h2>

            <div class="flex items-center space-x-4 ml-auto">
                <span class="text-sm bg-blue-100 text-blue-800 py-1 px-3 rounded-full font-semibold hidden md:inline-block">
                    {{ strtoupper(auth()->user()->role) }}
                </span>
                
                <div class="relative inline-block text-left" id="walletDropdown">
                    <button type="button" class="flex items-center focus:outline-none" onclick="document.getElementById('walletDropdownMenu').classList.toggle('hidden');">
                        <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-extrabold border-2 border-white shadow-sm hover:ring-2 hover:ring-blue-300 transition cursor-pointer">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </button>

                    <div id="walletDropdownMenu" class="hidden absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 origin-top-right transition-all">
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
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-lg shadow-blue-200 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] relative overflow-hidden">
                        <div class="relative z-10">
                            <p class="text-blue-100 text-sm font-medium mb-1">Saldo Tersedia</p>
                            <p class="text-4xl font-extrabold tracking-tight">Rp{{ number_format($wallet->balance ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Request Top Up Saldo</h3>
                        
                        <form action="{{ route('wallet.topup') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nominal (Rp)</label>
                                <input type="number" name="amount" min="10000" step="1000" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none transition bg-gray-50 focus:bg-white" placeholder="Contoh: 50000">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Metode Pembayaran</label>
                                <select name="payment_method" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none transition bg-gray-50 focus:bg-white">
                                    <option value="" disabled selected>-- Pilih Bank Tujuan --</option>
                                    <option value="Transfer BCA">Transfer BCA (0123456789 a.n JasaQu)</option>
                                    <option value="Transfer Mandiri">Transfer Mandiri (9876543210 a.n JasaQu)</option>
                                    <option value="QRIS">Scan QRIS</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Upload Bukti Transfer</label>
                                <input type="file" name="proof_image" accept="image/*" required class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none transition bg-gray-50 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-xs text-gray-400 mt-1">*Format: JPG/PNG. Maks: 2MB</p>
                            </div>
                            
                            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-blue-700 transition shadow-sm mt-2">
                                Kirim & Upload Bukti
                            </button>
                        </form>
                    </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-full">
                        <h3 class="font-bold text-gray-900 mb-4">Riwayat Transaksi Dompet</h3>
                        
                        @if($transactions->isEmpty())
                            <div class="text-center py-10 text-gray-500">
                                Belum ada riwayat transaksi.
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-100">
                                    <thead>
                                        <tr>
                                            <th class="py-3 text-left text-xs font-bold text-gray-400 uppercase">Tanggal</th>
                                            <th class="py-3 text-left text-xs font-bold text-gray-400 uppercase">Tipe</th>
                                            <th class="py-3 text-left text-xs font-bold text-gray-400 uppercase">Nominal</th>
                                            <th class="py-3 text-left text-xs font-bold text-gray-400 uppercase">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($transactions as $trx)
                                        <tr>
                                            <td class="py-3 text-sm text-gray-600">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                                            <td class="py-3 text-sm">
                                                @if($trx->type == 'deposit')
                                                    <span class="text-green-600 font-bold">Top Up</span>
                                                @elseif($trx->type == 'payment')
                                                    <span class="text-red-600 font-bold">Pembayaran</span>
                                                @else
                                                    <span class="text-gray-600 font-bold">{{ ucfirst($trx->type) }}</span>
                                                @endif
                                            </td>
                                            <td class="py-3 text-sm font-bold text-gray-900">Rp{{ number_format($trx->amount, 0, ',', '.') }}</td>
                                            <td class="py-3 text-sm">
                                                @if($trx->status == 'pending')
                                                    <span class="bg-yellow-100 text-yellow-700 py-1 px-2 rounded-lg text-xs font-bold">Pending</span>
                                                @elseif($trx->status == 'approved')
                                                    <span class="bg-green-100 text-green-700 py-1 px-2 rounded-lg text-xs font-bold">Sukses</span>
                                                @else
                                                    <span class="bg-red-100 text-red-700 py-1 px-2 rounded-lg text-xs font-bold">Gagal</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>