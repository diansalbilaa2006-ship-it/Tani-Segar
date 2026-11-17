<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Menampilkan riwayat pesanan pembeli
    public function index()
    {
        $orders = Order::with([
                'farmer',
                'items',
                'payment',
                'shipment'
            ])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pembeli.orders.index', compact('orders'));
    }

    // Menampilkan detail pesanan
    public function show($id)
    {
        $order = Order::with([
                'farmer',
                'items',
                'payment',
                'shipment'
            ])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pembeli.orders.show', compact('order'));
    }

    // Upload bukti pembayaran transfer
    public function uploadPaymentProof(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'bukti_pembayaran.required' => 'Silakan pilih bukti pembayaran.',
            'bukti_pembayaran.image' => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'bukti_pembayaran.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $order = Order::where('user_id', Auth::id())
            ->with('payment')
            ->findOrFail($id);

        $payment = $order->payment;

        if (!$payment || $payment->metode_pembayaran !== 'transfer') {
            return back()->with('error', 'Pesanan ini tidak menggunakan pembayaran transfer.');
        }

        if (!in_array($payment->status_pembayaran, ['menunggu', 'ditolak'])) {
            return back()->with('error', 'Bukti pembayaran tidak dapat diunggah pada status ini.');
        }

        if ($payment->bukti_pembayaran) {
            Storage::disk('public')->delete($payment->bukti_pembayaran);
        }

        $path = $request->file('bukti_pembayaran')
            ->store('bukti-pembayaran', 'public');

        $payment->update([
            'bukti_pembayaran' => $path,
            'status_pembayaran' => 'menunggu_verifikasi',
            'tanggal_bayar' => now(),
        ]);

        return redirect()
            ->route('pembeli.orders.show', $order->id)
            ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }

    // Konfirmasi pesanan sudah diterima pembeli
    public function confirmReceived($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['shipment', 'payment'])
            ->findOrFail($id);

        if (
            $order->status_pesanan !== 'dikirim' ||
            !$order->shipment ||
            $order->shipment->status_pengiriman !== 'dikirim'
        ) {
            return back()->with('error', 'Pesanan belum dapat dikonfirmasi diterima.');
        }

        if (!$order->payment) {
            return back()->with('error', 'Data pembayaran tidak ditemukan.');
        }

        DB::transaction(function () use ($order) {

            // Ubah status pesanan menjadi selesai
            $order->update([
                'status_pesanan' => 'selesai',
            ]);

            // Ubah status pengiriman menjadi diterima
            $order->shipment->update([
                'status_pengiriman' => 'diterima',
                'tanggal_diterima' => now(),
            ]);

            // Pembayaran COD dianggap berhasil setelah pesanan diterima
            if ($order->payment->metode_pembayaran === 'cod') {
                $order->payment->update([
                    'status_pembayaran' => 'berhasil',
                    'tanggal_bayar' => now(),
                ]);
            }
        });

        return redirect()
            ->route('pembeli.orders.show', $order->id)
            ->with('success', 'Terima kasih! Pesanan berhasil dikonfirmasi diterima.');
    }
}
