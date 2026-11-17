<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Menampilkan daftar pesanan milik petani
    public function index()
    {
        $farmer = Auth::user()->farmer;

        if (!$farmer) {
            abort(403, 'Data petani tidak ditemukan.');
        }

        $orders = Order::with([
                'user',
                'items',
                'payment',
                'shipment'
            ])
            ->where('farmer_id', $farmer->id)
            ->latest()
            ->paginate(10);

        return view('petani.orders.index', compact('orders'));
    }

    // Menampilkan detail pesanan
    public function show($id)
    {
        $farmer = Auth::user()->farmer;

        if (!$farmer) {
            abort(403, 'Data petani tidak ditemukan.');
        }

        $order = Order::with([
                'user',
                'items',
                'payment',
                'shipment'
            ])
            ->where('farmer_id', $farmer->id)
            ->findOrFail($id);

        return view('petani.orders.show', compact('order'));
    }

    // Memproses pengiriman pesanan
    public function ship(Request $request, $id)
    {
        $request->validate([
            'nama_kurir' => 'required|string|max:100',
            'nomor_resi' => 'required|string|max:100',
            'catatan' => 'nullable|string|max:500',
        ]);

        $farmer = Auth::user()->farmer;

        if (!$farmer) {
            abort(403, 'Data petani tidak ditemukan.');
        }

        $order = Order::where('farmer_id', $farmer->id)
            ->findOrFail($id);

        if ($order->status_pesanan !== 'diproses') {
            return back()->with('error', 'Pesanan ini tidak dapat dikirim.');
        }

        // Simpan informasi pengiriman
        $order->shipment()->updateOrCreate(
            [],
            [
                'nama_kurir' => $request->nama_kurir,
                'nomor_resi' => $request->nomor_resi,
                'alamat_pengiriman' => $order->alamat_pengiriman,
                'status_pengiriman' => 'dikirim',
                'tanggal_kirim' => now(),
                'catatan' => $request->catatan,
            ]
        );

        // Ubah status pesanan
        $order->update([
            'status_pesanan' => 'dikirim',
        ]);

        return redirect()
            ->route('petani.orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dikirim.');
    }
}
