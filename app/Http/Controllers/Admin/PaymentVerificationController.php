<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentVerificationController extends Controller
{
    // Menampilkan daftar pembayaran
    public function index()
    {
        $payments = Payment::with([
                'order.user',
                'order.farmer'
            ])
            ->where('status_pembayaran', 'menunggu_verifikasi')
            ->latest()
            ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    // Menyetujui pembayaran
    public function approve($id)
    {
        DB::transaction(function () use ($id) {
            $payment = Payment::with('order')
                ->lockForUpdate()
                ->findOrFail($id);

            if ($payment->status_pembayaran !== 'menunggu_verifikasi') {
                abort(422, 'Pembayaran ini sudah diproses.');
            }

            $payment->update([
                'status_pembayaran' => 'berhasil',
                'catatan_admin' => null,
            ]);

            $payment->order->update([
                'status_pesanan' => 'diproses',
            ]);
        });

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    // Menolak pembayaran
    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ]);

        $payment = Payment::with('order')->findOrFail($id);

        if ($payment->status_pembayaran !== 'menunggu_verifikasi') {
            return back()->with('error', 'Pembayaran ini sudah diproses.');
        }

        $payment->update([
            'status_pembayaran' => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Pembayaran berhasil ditolak.');
    }
}
