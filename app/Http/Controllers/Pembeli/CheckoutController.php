<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    // Menampilkan halaman checkout
    public function index()
    {
        $cart = Auth::user()->cart;

        if (!$cart || $cart->items()->count() === 0) {
            return redirect()
                ->route('pembeli.products.index')
                ->with('error', 'Keranjang belanja kamu masih kosong.');
        }

        $items = $cart->items()
            ->with(['product.farmer'])
            ->get();

        $total = $items->sum(function ($item) {
            return $item->harga * $item->jumlah;
        });

        return view('pembeli.checkout.index', compact(
            'cart',
            'items',
            'total'
        ));
    }

    // Memproses pesanan dari checkout
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_telepon' => ['required', 'string', 'max:20'],
            'alamat_pengiriman' => ['required', 'string', 'max:1000'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'metode_pembayaran' => ['required', 'in:transfer,cod'],
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($validated, $user) {

            // Ambil keranjang dan kunci selama proses pesanan
            $cart = Cart::where('user_id', $user->id)
                ->lockForUpdate()
                ->first();

            if (!$cart) {
                throw ValidationException::withMessages([
                    'keranjang' => 'Keranjang belanja tidak ditemukan.',
                ]);
            }

            $cartItems = CartItem::where('cart_id', $cart->id)
                ->get();

            if ($cartItems->isEmpty()) {
                throw ValidationException::withMessages([
                    'keranjang' => 'Keranjang belanja kamu masih kosong.',
                ]);
            }

            $groupedItems = [];

            // Periksa stok dan kelompokkan produk berdasarkan petani
            foreach ($cartItems as $item) {
                $product = Product::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    throw ValidationException::withMessages([
                        'stok' => 'Salah satu produk sudah tidak tersedia.',
                    ]);
                }

                if (
                    $product->status !== 'aktif' ||
                    $product->stok < $item->jumlah
                ) {
                    throw ValidationException::withMessages([
                        'stok' => 'Stok produk ' . $product->nama_produk .
                            ' tidak mencukupi. Silakan periksa keranjang.',
                    ]);
                }

                $groupedItems[$product->farmer_id][] = [
                    'item' => $item,
                    'product' => $product,
                ];
            }

            // Buat satu pesanan untuk setiap petani
            foreach ($groupedItems as $farmerId => $entries) {

                $subtotal = collect($entries)->sum(function ($entry) {
                    return $entry['item']->harga *
                        $entry['item']->jumlah;
                });

                $order = Order::create([
                    'user_id' => $user->id,
                    'farmer_id' => $farmerId,
                    'kode_pesanan' => 'TS-' .
                        now()->format('YmdHis') . '-' .
                        Str::upper(Str::random(5)),
                    'alamat_pengiriman' => $validated['alamat_pengiriman'],
                    'no_telepon' => $validated['no_telepon'],
                    'catatan' => $validated['catatan'] ?? null,
                    'subtotal' => $subtotal,
                    'ongkir' => 0,
                    'total_harga' => $subtotal,
                    'metode_pembayaran' =>
                        $validated['metode_pembayaran'],
                    'status_pesanan' =>
                        $validated['metode_pembayaran'] === 'cod'
                            ? 'diproses'
                            : 'menunggu_pembayaran',
                ]);

                // Simpan detail setiap produk
                foreach ($entries as $entry) {
                    $item = $entry['item'];
                    $product = $entry['product'];

                    $order->items()->create([
                        'product_id' => $product->id,
                        'nama_produk' => $product->nama_produk,
                        'harga' => $item->harga,
                        'jumlah' => $item->jumlah,
                        'subtotal' => $item->harga * $item->jumlah,
                    ]);

                    // Kurangi stok produk
                    $product->decrement('stok', $item->jumlah);
                    $product->refresh();

                    if ($product->stok <= 0) {
                        $product->update([
                            'status' => 'habis',
                        ]);
                    }
                }

                // Buat data pembayaran
                Payment::create([
                    'order_id' => $order->id,
                    'metode_pembayaran' =>
                        $validated['metode_pembayaran'],
                    'jumlah_bayar' => $subtotal,
                    'status_pembayaran' => 'menunggu',
                ]);

                // Buat data pengiriman
                Shipment::create([
                    'order_id' => $order->id,
                    'alamat_pengiriman' =>
                        $validated['alamat_pengiriman'],
                    'status_pengiriman' => 'menunggu',
                ]);
            }

            // Kosongkan keranjang setelah semua pesanan berhasil dibuat
            CartItem::where('cart_id', $cart->id)->delete();
        });

        return redirect()
            ->route('pembeli.cart.index')
            ->with(
                'success',
                'Pesanan berhasil dibuat! Silakan lanjutkan proses pembayaran.'
            );
    }
}
