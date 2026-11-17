<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan isi keranjang
    public function index()
    {
        $cart = Auth::user()->cart()->firstOrCreate();

        $items = $cart->items()
            ->with(['product.category', 'product.farmer'])
            ->get();

        return view('pembeli.cart.index', compact('cart', 'items'));
    }

    // Menambahkan produk ke keranjang
    public function store(Request $request, $productId)
    {
        $product = Product::where('status', 'aktif')
            ->where('id', $productId)
            ->firstOrFail();

        $jumlah = (int) $request->input('jumlah', 1);

        if ($jumlah < 1) {
            return back()->with('error', 'Jumlah produk tidak valid.');
        }

        if ($product->stok < $jumlah) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $cart = Auth::user()->cart()->firstOrCreate();

        $cartItem = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $totalJumlah = $cartItem->jumlah + $jumlah;

            if ($totalJumlah > $product->stok) {
                return back()->with(
                    'error',
                    'Jumlah melebihi stok yang tersedia.'
                );
            }

            $cartItem->update([
                'jumlah' => $totalJumlah,
                'harga' => $product->harga,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'jumlah' => $jumlah,
                'harga' => $product->harga,
            ]);
        }

        return back()->with(
            'success',
            'Produk berhasil ditambahkan ke keranjang!'
        );
    }

    // Mengubah jumlah produk
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $cart = Auth::user()->cart;

        if (!$cart) {
            abort(404);
        }

        $item = $cart->items()
            ->with('product')
            ->findOrFail($itemId);

        if (!$item->product || $request->jumlah > $item->product->stok) {
            return back()->with(
                'error',
                'Jumlah melebihi stok yang tersedia.'
            );
        }

        $item->update([
            'jumlah' => $request->jumlah,
            'harga' => $item->product->harga,
        ]);

        return back()->with(
            'success',
            'Jumlah produk berhasil diperbarui.'
        );
    }

    // Menghapus produk dari keranjang
    public function destroy($itemId)
    {
        $cart = Auth::user()->cart;

        if (!$cart) {
            abort(404);
        }

        $item = $cart->items()->findOrFail($itemId);

        $item->delete();

        return back()->with(
            'success',
            'Produk berhasil dihapus dari keranjang.'
        );
    }
}
