<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        // Ambil data jasa beserta relasi kategori, provider, dan paketnya
        $services = Service::with(['category', 'provider', 'packages'])
                    ->where('status', 'active')
                    ->latest()
                    ->get();

        return view('welcome', compact('services'));
    }

    public function show($id)
    {
        // Cari jasa berdasarkan ID, bawa juga data kategori, provider, dan paketnya
        $service = \App\Models\Service::with(['category', 'provider', 'packages'])->findOrFail($id);

        // Tampilkan ke halaman view 'service.show'
        return view('service.show', compact('service'));
    }
}