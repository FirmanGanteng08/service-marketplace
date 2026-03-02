<script src="https://cdn.tailwindcss.com"></script>

<div class="bg-gray-50 min-h-screen">
    <nav class="bg-white shadow-sm py-4 px-8 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-600">JasaQu</h1>
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-600 px-4">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 px-4">Log in</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Daftar</a>
                @endauth
            @endif
        </div>
    </nav>

    <header class="py-16 px-8 text-center">
        <h2 class="text-4xl font-extrabold text-gray-900">Temukan Jasa Profesional <br><span class="text-blue-600">Berbasis Paket</span></h2>
        <p class="mt-4 text-gray-600">Harga tetap, kualitas terjamin, tanpa nego ribet.</p>
    </header>

    <main class="max-w-7xl mx-auto px-8 pb-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($services as $service)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-shadow border border-gray-100">
                <div class="h-48 bg-blue-100 flex items-center justify-center">
                    <span class="text-blue-400 font-semibold">{{ $service->category->name }}</span>
                </div>
                
                <div class="p-6">
                    <p class="text-xs font-semibold text-blue-500 uppercase tracking-wide">{{ $service->category->name }}</p>
                    <h3 class="mt-2 text-xl font-bold text-gray-900">{{ $service->title }}</h3>
                    <p class="mt-2 text-gray-500 text-sm line-clamp-2">{{ $service->description }}</p>
                    
                    <div class="mt-4 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400">Mulai dari</p>
                            <p class="text-lg font-bold text-blue-600">Rp{{ number_format($service->packages->min('price'), 0, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('service.show', $service->id) }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-600 hover:text-white transition">Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>
</div>