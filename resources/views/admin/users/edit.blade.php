<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - Admin JasaQu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 h-screen flex flex-col">

    <header class="bg-white border-b border-gray-100 py-4 px-8 flex justify-between items-center shrink-0">
        <h1 class="text-2xl font-extrabold text-blue-600">JasaQu Admin</h1>
        <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-gray-500 hover:text-blue-600">&larr; Batal & Kembali</a>
    </header>

    <main class="flex-1 overflow-y-auto p-8 flex justify-center">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 w-full max-w-2xl">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Pengguna: <span class="text-blue-600">{{ $user->name }}</span></h2>

            @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-lg mb-6 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT') <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kata Sandi Baru <span class="text-gray-400 font-normal">(Kosongkan jika tidak ingin mengubah)</span></label>
                    <input type="password" name="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none" placeholder="Ketik sandi baru...">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Role (Hak Akses)</label>
                        <select name="role" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none bg-white">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User (Pembeli)</option>
                            <option value="provider" {{ $user->role == 'provider' ? 'selected' : '' }}>Provider (Penjual Jasa)</option>
                            <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Status Akun</label>
                        <select name="status" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 outline-none bg-white">
                            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>Suspended (Diblokir)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 mt-6 flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition">Update Data Pengguna</button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>