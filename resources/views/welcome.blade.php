<script src="https://cdn.tailwindcss.com"></script>

<div class="bg-gray-50 min-h-screen">
    <nav class="bg-white shadow-sm py-4 px-8 flex justify-between items-center relative z-50">
        <h1 class="text-2xl font-bold text-blue-600">JasaQu</h1>
        <div>
            @if (Route::has('login'))
                @auth
                    <div class="relative inline-block text-left" id="profileDropdown">
                        <button type="button" class="flex items-center gap-3 focus:outline-none" onclick="toggleDropdown()">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-blue-600 font-semibold">{{ strtoupper(auth()->user()->role) }}</p>
                            </div>
                            <div class="h-11 w-11 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-extrabold border-2 border-white shadow-sm hover:ring-2 hover:ring-blue-300 transition">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </button>

                        <div id="dropdownMenu" class="hidden absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 origin-top-right transition-all">
                            
                            <div class="px-5 py-3 border-b border-gray-50 mb-2 bg-gray-50/50 rounded-t-2xl">
                                <p class="text-xs text-gray-500 font-medium">Masuk sebagai:</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <a href="{{ route('dashboard') }}" class="flex items-center px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition">
                                <span class="mr-3">📊</span> Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition">
                                <span class="mr-3">⚙️</span> Detail Profil
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-50 mt-2 pt-2">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-5 py-2.5 text-sm text-red-600 hover:bg-red-50 font-bold transition text-left">
                                    <span class="mr-3">🚪</span> Keluar (Logout)
                                </button>
                            </form>
                        </div>
                    </div>

                    <script>
                        function toggleDropdown() {
                            document.getElementById('dropdownMenu').classList.toggle('hidden');
                        }
                        // Menutup dropdown otomatis jika user klik area kosong di luar kotak
                        window.onclick = function(event) {
                            if (!event.target.closest('#profileDropdown')) {
                                var dropdown = document.getElementById('dropdownMenu');
                                if (!dropdown.classList.contains('hidden')) {
                                    dropdown.classList.add('hidden');
                                }
                            }
                        }
                    </script>

                @else
                    <a href="{{ route('login') }}" class="text-gray-600 font-semibold hover:text-blue-600 px-4 transition">Log in</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white font-bold px-6 py-2.5 rounded-xl hover:bg-blue-700 shadow-sm shadow-blue-200 transition">Daftar</a>
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