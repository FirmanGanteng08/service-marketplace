<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Profil - JasaQu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 min-h-screen pb-20">

    <header class="bg-white border-b border-gray-100 py-4 px-8 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <h1 class="text-2xl font-extrabold text-blue-600">JasaQu</h1>
        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-500 hover:text-blue-600 transition">&larr; Kembali ke Dashboard</a>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 space-y-8">
        
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Pengaturan Profil</h2>
            <p class="text-gray-500 mt-2">Kelola informasi pribadi, kata sandi, dan keamanan akun Anda.</p>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Informasi Profil</h3>
            <p class="text-sm text-gray-500 mb-6 border-b border-gray-100 pb-4">Perbarui nama dan alamat email akun Anda.</p>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-5 max-w-xl">
                @csrf
                @method('patch')

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none bg-gray-50 focus:bg-white transition">
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none bg-gray-50 focus:bg-white transition">
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-blue-700 transition shadow-sm">Simpan Perubahan</button>
                    
                    @if (session('status') === 'profile-updated')
                        <span class="text-sm text-green-600 font-semibold flex items-center">
                            <span class="mr-1">✓</span> Tersimpan.
                        </span>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Ubah Kata Sandi</h3>
            <p class="text-sm text-gray-500 mb-6 border-b border-gray-100 pb-4">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>

            <form method="post" action="{{ route('password.update') }}" class="space-y-5 max-w-xl">
                @csrf
                @method('put')

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none bg-gray-50 focus:bg-white transition">
                    @error('current_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kata Sandi Baru</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none bg-gray-50 focus:bg-white transition">
                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none bg-gray-50 focus:bg-white transition">
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="bg-gray-800 text-white font-bold py-3 px-6 rounded-xl hover:bg-gray-900 transition shadow-sm">Update Kata Sandi</button>
                    
                    @if (session('status') === 'password-updated')
                        <span class="text-sm text-green-600 font-semibold flex items-center">
                            <span class="mr-1">✓</span> Tersimpan.
                        </span>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-red-50 p-8 rounded-3xl shadow-sm border border-red-100">
            <h3 class="text-xl font-bold text-red-600 mb-2">Hapus Akun</h3>
            <p class="text-sm text-red-500 mb-6 border-b border-red-200 pb-4">Setelah akun Anda dihapus, semua data dan sumber daya akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.</p>

            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-5 max-w-xl" onsubmit="return confirm('Peringatan Final! Apakah Anda yakin ingin menghapus akun ini secara permanen?');">
                @csrf
                @method('delete')

                <div>
                    <label class="block text-sm font-bold text-red-700 mb-1">Masukkan kata sandi untuk konfirmasi</label>
                    <input type="password" name="password" required placeholder="Kata sandi Anda" class="w-full px-4 py-3 rounded-xl border border-red-300 focus:ring-2 focus:ring-red-600 outline-none bg-white transition">
                    @error('password', 'userDeletion') <span class="text-red-600 font-bold text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="bg-red-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-red-700 transition shadow-sm">Hapus Akun Permanen</button>
                </div>
            </form>
        </div>

    </main>

</body>
</html>