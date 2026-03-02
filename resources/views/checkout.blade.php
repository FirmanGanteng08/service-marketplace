<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - JasaQu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 min-h-screen pb-20">

    <nav class="bg-white shadow-sm py-4 px-8 flex justify-between items-center mb-8">
        <h1 class="text-2xl font-extrabold text-blue-600">JasaQu Checkout</h1>
        <a href="{{ route('service.show', $service->id) }}" class="text-gray-500 hover:text-blue-600 font-semibold">&larr; Batal & Kembali</a>
    </nav>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <span class="font-bold mr-2">Gagal!</span> {{ session('error') }}
            </div>
        @endif

        <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Selesaikan Pesanan Anda</h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Ringkasan Jasa</h3>
                    
                    <div class="flex items-start mb-6">
                        <div class="h-16 w-16 bg-blue-100 rounded-xl flex items-center justify-center text-blue-500 font-bold text-xl shrink-0">
                            {{ substr($service->category->name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">{{ $service->category->name }}</p>
                            <h4 class="text-lg font-bold text-gray-900 mt-1">{{ $service->title }}</h4>
                            <p class="text-sm text-gray-500 mt-1">Provider: <span class="font-semibold text-gray-800">{{ $service->provider->name }}</span></p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase">Paket {{ $package->name }}</span>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Harga Paket</p>
                                <p class="text-2xl font-extrabold text-gray-900">Rp{{ number_format($package->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-600 mb-4 space-x-4">
                            <span class="flex items-center"><span class="mr-2">⏱️</span> {{ $package->duration_days }} Hari Pengerjaan</span>
                            <span class="flex items-center"><span class="mr-2">🔄</span> {{ $package->revision_limit == 99 ? 'Revisi Unlimited' : $package->revision_limit . 'x Revisi' }}</span>
                        </div>

                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <p class="text-sm font-bold text-gray-700 mb-2">Fitur yang didapat:</p>
                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @php $features = json_decode($package->features, true) ?? []; @endphp
                                @foreach($features as $feature)
                                <li class="flex items-center text-sm text-gray-600">
                                    <span class="text-green-500 mr-2">✓</span> {{ $feature }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <form action="{{ route('checkout.process', ['service' => $service->id, 'package' => $package->id]) }}" method="POST" class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 sticky top-8">
                    @csrf
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Pembayaran</h3>

                    @php
                        $userBalance = auth()->user()->wallet->balance ?? 0;
                        $isEnough = $userBalance >= $package->price;
                    @endphp

                    <div class="bg-{{ $isEnough ? 'blue' : 'red' }}-50 border border-{{ $isEnough ? 'blue' : 'red' }}-100 rounded-xl p-4 mb-6">
                        <p class="text-sm text-{{ $isEnough ? 'blue' : 'red' }}-600 font-medium mb-1">Saldo Dompet JasaQu</p>
                        <p class="text-2xl font-extrabold text-{{ $isEnough ? 'blue' : 'red' }}-700">Rp{{ number_format($userBalance, 0, ',', '.') }}</p>
                        
                        @if(!$isEnough)
                            <p class="text-xs text-red-500 mt-2 font-medium">⚠️ Saldo Anda kurang Rp{{ number_format($package->price - $userBalance, 0, ',', '.') }} untuk membeli paket ini.</p>
                        @endif
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Catatan untuk Penjual (Opsional)</label>
                        <textarea name="notes" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none resize-none bg-gray-50 focus:bg-white transition" placeholder="Contoh: Tolong buatkan desain dengan dominan warna merah..."></textarea>
                    </div>

                    <div class="border-t border-gray-100 pt-4 mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-semibold text-gray-900">Rp{{ number_format($package->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-500">Biaya Admin</span>
                            <span class="font-semibold text-green-500">Gratis</span>
                        </div>
                        <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                            <span class="text-lg font-bold text-gray-900">Total Bayar</span>
                            <span class="text-2xl font-black text-blue-600">Rp{{ number_format($package->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($isEnough)
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 px-4 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200" onclick="return confirm('Selesaikan pembayaran? Saldo Anda akan dipotong sebesar Rp{{ number_format($package->price, 0, ',', '.') }}')">
                            Bayar Sekarang
                        </button>
                    @else
                        <button type="button" disabled class="w-full bg-gray-300 text-gray-500 font-bold py-4 px-4 rounded-xl cursor-not-allowed">
                            Saldo Tidak Cukup
                        </button>
                        <a href="#" class="block text-center mt-4 text-sm font-bold text-blue-600 hover:underline">Top Up Saldo &rarr;</a>
                    @endif

                </form>
            </div>

        </div>
    </main>
</body>
</html>