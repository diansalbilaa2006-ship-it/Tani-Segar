<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ProductDetailController extends Controller
{
    public function show($id)
    {
        $product = Product::with([
            'category',
            'farmer',
        ])
        ->withCount('reviews')
        ->where('status', 'aktif')
        ->findOrFail($id);

        // Menampilkan ulasan pembeli
        $reviews = $product->reviews()
            ->with('user')
            ->latest()
            ->paginate(10);

        // Pesanan selesai milik pembeli yang belum diulas
        $eligibleOrders = Order::where('user_id', Auth::id())
            ->where('status_pesanan', 'selesai')
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->whereDoesntHave('items', function ($query) use ($product) {
                $query->where('product_id', $product->id)
                    ->whereExists(function ($subquery) use ($product) {
                        $subquery->selectRaw('1')
                            ->from('reviews')
                            ->whereColumn('reviews.order_id', 'orders.id')
                            ->whereColumn('reviews.product_id', 'order_items.product_id')
                            ->where('reviews.user_id', Auth::id());
                    });
            })
            ->latest()
            ->get();

        return view('pembeli.products.show', compact(
            'product',
            'reviews',
            'eligibleOrders'
        ));
    }
}
