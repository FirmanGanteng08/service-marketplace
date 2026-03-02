<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $service->title }} - JasaQu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 min-h-screen pb-20">

    <nav class="bg-white shadow-sm py-4 px-8 flex justify-between items-center mb-8">
        <a href="{{ route('home') }}" class="text-2xl font-extrabold text-blue-600">JasaQu</a>
        <div>
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 font-semibold">&larr; Kembali ke Beranda</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">
            <span class="inline-block px-4 py-1 rounded-full bg-blue-50 text-blue-600 font-bold text-sm mb-4">
                {{ $service->category->name }}
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">{{ $service->title }}</h1>
            
            <div class="flex items-center text-gray-500 text-sm">
                <span class="font-medium">Oleh: <span class="text-gray-900 font-bold">{{ $service->provider->name }}</span></span>
                <span class="mx-3">•</span>
                <span class="text-green-600 font-semibold">Status: Aktif</span>
            </div>

            <div class="mt-8 border-t border-gray-100 pt-8">
                <h3 class="text-xl font-bold text-gray-900 mb-3">Deskripsi Jasa</h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ $service->description }}
                </p>
            </div>
        </div>

        <h3 class="text-2xl font-extrabold text-center text-gray-900 mb-8">Pilih Paket Anda</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($service->packages as $package)
            <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl transition-shadow border {{ $package->name == 'Standard' ? 'border-blue-500 shadow-blue-100 relative' : 'border-gray-100' }} flex flex-col overflow-hidden">
                
                @if($package->name == 'Standard')
                    <div class="bg-blue-600 text-white text-xs font-bold uppercase tracking-wider text-center py-2">
                        Paling Laris
                    </div>
                @endif

                <div class="p-8 flex-1">
                    <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $package->name }}</h4>
                    <p class="text-3xl font-extrabold text-blue-600 mb-6">Rp{{ number_format($package->price, 0, ',', '.') }}</p>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <span class="mr-2">⏱️</span> Pengerjaan {{ $package->duration_days }} Hari
                    </div>
                    <div class="flex items-center text-sm text-gray-500 mb-6 pb-6 border-b border-gray-100">
                        <span class="mr-2">🔄</span> Revisi {{ $package->revision_limit == 99 ? 'Unlimited' : $package->revision_limit . ' Kali' }}
                    </div>

                    <ul class="space-y-3 mb-8">
                        @php
                            $features = json_decode($package->features, true) ?? [];
                        @endphp

                        @foreach($features as $feature)
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mr-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm text-gray-600">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="p-8 pt-0 mt-auto">
                    <form action="{{ route('checkout', ['service' => $service->id, 'package' => $package->id]) }}" method="GET">
                        <button type="submit" class="w-full py-3 px-4 rounded-xl font-bold transition-colors {{ $package->name == 'Standard' ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">
                            Pilih Paket {{ $package->name }}
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

    </main>

</body>
</html>