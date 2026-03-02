<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Models\ProviderProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        abort_if(auth()->user()->role !== 'super_admin', 403, 'Akses Ditolak!');
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // 1. Menampilkan Form Tambah User
    public function create()
    {
        abort_if(auth()->user()->role !== 'super_admin', 403);
        return view('admin.users.create');
    }

    // 2. Menyimpan Data User Baru ke Database
    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'super_admin', 403);

        // Validasi input form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:super_admin,provider,user',
            'status' => 'required|in:active,suspended',
        ]);

        // Buat User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        // Jika bukan admin, buatkan Dompet (Wallet) otomatis
        if ($user->role !== 'super_admin') {
            Wallet::create(['user_id' => $user->id, 'balance' => 0]);
        }

        // Jika dia provider, buatkan profil toko kosong
        if ($user->role === 'provider') {
            ProviderProfile::create([
                'user_id' => $user->id,
                'business_name' => $user->name . ' Studio', // Nama toko default
                'is_verified' => true
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan beserta dompetnya!');
    }

    // 3. Menampilkan Form Edit User
    public function edit(string $id)
    {
        abort_if(auth()->user()->role !== 'super_admin', 403);
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // 4. Menyimpan Perubahan Edit User
    public function update(Request $request, string $id)
    {
        abort_if(auth()->user()->role !== 'super_admin', 403);
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:super_admin,provider,user',
            'status' => 'required|in:active,suspended',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = $request->status;

        // Jika form password diisi, berarti admin ingin mereset password user tersebut
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    // 5. Menghapus User
    public function destroy(string $id)
    {
        abort_if(auth()->user()->role !== 'super_admin', 403);
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}