<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServicePackage;
use App\Models\Order;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 1. Menampilkan Halaman Checkout
    public function checkout(Service $service, ServicePackage $package)
    {
        // Pastikan paket benar-benar milik jasa tersebut
        abort_if($package->service_id !== $service->id, 404);

        // Jangan izinkan provider membeli jasanya sendiri
        abort_if(auth()->id() === $service->provider_id, 403, 'Anda tidak bisa membeli jasa Anda sendiri.');

        return view('checkout', compact('service', 'package'));
    }

    // 2. Memproses Pembayaran & Potong Saldo
    public function process(Request $request, Service $service, ServicePackage $package)
    {
        abort_if($package->service_id !== $service->id, 404);

        $user = auth()->user();
        $wallet = $user->wallet;

        // Cek apakah saldo cukup
        if (!$wallet || $wallet->balance < $package->price) {
            return back()->with('error', 'Saldo dompet Anda tidak cukup. Silakan Top Up terlebih dahulu.');
        }

        // Gunakan DB Transaction agar jika terjadi error di tengah jalan, saldo tidak terpotong sia-sia
        DB::beginTransaction();
        try {
            // A. Potong Saldo Pembeli
            $wallet->balance -= $package->price;
            $wallet->save();

            // B. Buat Record Transaksi Dompet (Pengeluaran)
            $transaction = WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'payment',
                'amount' => $package->price,
                'reference_id' => 'PAY-' . time(),
            ]);

            // C. Buat Order Baru
            $order = Order::create([
                'order_code' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => $user->id,
                'provider_id' => $service->provider_id,
                'service_id' => $service->id,
                'package_id' => $package->id,
                'total_price' => $package->price,
                'user_notes' => $request->notes,
                'status' => 'paid_waiting_confirmation', // Langsung lunas, nunggu di-acc penjual
            ]);

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil! Menunggu konfirmasi dari Penjual.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}