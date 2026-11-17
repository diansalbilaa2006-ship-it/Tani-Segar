<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Menyimpan ulasan produk
    public function store(Request $request, $id)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Silakan pilih rating bintang.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'komentar.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        // Pastikan produk tersedia
        $product = Product::findOrFail($id);

        // Pastikan pesanan milik pembeli dan sudah selesai
        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->where('status_pesanan', 'selesai')
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->first();

        if (!$order) {
            return back()->with('error', 'Pesanan tidak valid atau belum selesai.');
        }

        // Cegah ulasan ganda pada produk dan pesanan yang sama
        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->where('order_id', $order->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Produk pada pesanan ini sudah pernah diulas.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()
            ->route('pembeli.products.show', $product->id)
            ->with('success', 'Terima kasih! Ulasan berhasil dikirim.');
    }
}
