<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - JasaQu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="flex h-screen bg-white">

    <div class="hidden lg:flex lg:w-1/2 bg-blue-600 flex-col justify-center items-center text-white p-12 relative overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
        
        <div class="relative z-10 text-center max-w-md">
            <h1 class="text-5xl font-extrabold mb-6 tracking-tight">JasaQu</h1>
            <p class="text-lg text-blue-100 mb-8">Bergabunglah dengan ribuan pengguna lainnya. Mulai cari jasa atau tawarkan keahlian Anda sekarang juga.</p>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 overflow-y-auto">
        <div class="w-full max-w-md">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru 🚀</h2>
            <p class="text-gray-500 mb-8">Daftar secara gratis dan mulai perjalanan Anda.</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition bg-gray-50 focus:bg-white" placeholder="John Doe">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition bg-gray-50 focus:bg-white" placeholder="nama@email.com">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Mendaftar Sebagai</label>
                    <select name="role" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition bg-gray-50 focus:bg-white">
                        <option value="user">Pembeli (User)</option>
                        <option value="provider">Penjual Jasa (Provider)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition bg-gray-50 focus:bg-white" placeholder="Minimal 8 karakter">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition bg-gray-50 focus:bg-white" placeholder="Ulangi kata sandi">
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200 mt-6">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center mt-6 text-gray-600">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Masuk di sini</a>
            </p>
        </div>
    </div>

</body>
</html> 