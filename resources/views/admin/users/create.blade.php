<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - Admin JasaQu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 h-screen flex flex-col">

    <header class="bg-white border-b border-gray-100 py-4 px-8 flex justify-between items-center shrink-0">
        <h1 class="text-2xl font-extrabold text-blue-600">JasaQu Admin</h1>
        <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-gray-500 hover:text-blue-600">&larr; Kembali</a>
    </header>

    <main class="flex-1 overflow-y-auto p-8 flex justify-center">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 w-full max-w-2xl">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Tambah Pengguna Baru</h2>

            @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-lg mb-6 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none" placeholder="Masukkan nama">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none" placeholder="nama@email.com">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none" placeholder="Minimal 8 karakter">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Role (Hak Akses)</label>
                        <select name="role" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none bg-white">
                            <option value="user">User (Pembeli)</option>
                            <option value="provider">Provider (Penjual Jasa)</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Status Akun</label>
                        <select name="status" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none bg-white">
                            <option value="active">Active</option>
                            <option value="suspended">Suspended (Diblokir)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 mt-6 flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>