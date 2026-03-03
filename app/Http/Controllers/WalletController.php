<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Storage;

class WalletController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1. PENGAMAN: Jika Super Admin yang nyasar ke sini, tendang kembali ke Dashboard
        if ($user->role === 'super_admin') {
            return redirect()->route('dashboard')->with('error', 'Super Admin tidak membutuhkan Dompet Pembeli.');
        }

        // 2. Ambil dompet user
        $wallet = $user->wallet;

        // 3. PENGAMAN EXTRA: Jika karena suatu hal (error sistem) user ini belum punya dompet, buatkan otomatis
        if (!$wallet) {
            $wallet = Wallet::create(['user_id' => $user->id, 'balance' => 0]);
        }

        $transactions = WalletTransaction::where('wallet_id', $wallet->id)->latest()->get();

        return view('wallet.index', compact('wallet', 'transactions'));
    }

    public function topup(Request $request)
    {
        $user = auth()->user();

        // PENGAMAN: Admin dilarang Top Up
        abort_if($user->role === 'super_admin', 403, 'Admin tidak bisa melakukan Top Up.');

        $request->validate([
            'amount'         => 'required|numeric|min:10000',
            'payment_method' => 'required|string|in:Transfer BCA,Transfer Mandiri,QRIS',
            'proof_image'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'proof_image.required' => 'Foto bukti transfer wajib diunggah!',
            'proof_image.image'    => 'File harus berupa gambar (JPG/PNG).',
            'proof_image.max'      => 'Ukuran gambar maksimal 2MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('proof_image')) {
            $imagePath = $request->file('proof_image')->store('proofs', 'public');
        }

        WalletTransaction::create([
            'wallet_id'      => $user->wallet->id,
            'type'           => 'topup',
            'amount'         => $request->amount,
            'payment_method' => $request->payment_method,
            'proof_image'    => $imagePath,
            'status'         => 'pending', 
            'reference_id'   => 'TOPUP-' . strtoupper(uniqid())
        ]);

        return back()->with('success', 'Request Top Up berhasil dikirim! Silakan tunggu Admin mengecek bukti transfer Anda.');
    }
}