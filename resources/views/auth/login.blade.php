<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - JasaQu</title>
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
            <p class="text-lg text-blue-100 mb-8">Platform marketplace jasa terbaik. Temukan profesional untuk setiap kebutuhan proyek Anda dengan harga yang transparan.</p>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
        <div class="w-full max-w-md">
            <div class="lg:hidden text-center mb-8">
                <h1 class="text-4xl font-extrabold text-blue-600">JasaQu</h1>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang Kembali 👋</h2>
            <p class="text-gray-500 mb-8">Silakan masukkan email dan kata sandi Anda.</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition bg-gray-50 focus:bg-white" placeholder="nama@email.com">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition bg-gray-50 focus:bg-white" placeholder="••••••••">
                </div>

                <div class="flex justify-between items-center text-sm">
                    <label class="flex items-center text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-600"> Ingat saya
                    </label>
                    <a href="#" class="text-blue-600 font-semibold hover:underline">Lupa sandi?</a>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200 mt-4">
                    Masuk Sekarang
                </button>
            </form>

            <p class="text-center mt-8 text-gray-600">
                Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Daftar di sini</a>
            </p>
        </div>
    </div>

</body>
</html>