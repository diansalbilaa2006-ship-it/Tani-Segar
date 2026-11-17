<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan semua pesanan
    public function index(Request $request)
    {
        $query = Order::with([
            'user',
            'farmer.user',
            'payment',
            'shipment',
            'items',
        ])->latest();

        // Pencarian berdasarkan kode pesanan atau nama pembeli
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('kode_pesanan', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter berdasarkan status pesanan
        if ($request->filled('status')) {
            $query->where('status_pesanan', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    // Menampilkan detail pesanan
    public function show($id)
    {
        $order = Order::with([
            'user',
            'farmer.user',
            'items',
            'payment',
            'shipment',
        ])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }
}
