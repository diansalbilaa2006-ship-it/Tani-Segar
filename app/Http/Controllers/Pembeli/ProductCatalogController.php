<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductCatalogController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'farmer'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('status', 'aktif')
            ->where('stok', '>', 0)

            // Pencarian nama produk
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('nama_produk', 'like', '%' . $request->search . '%');
            })

            // Filter kategori
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })

            // Pengurutan produk
            ->when($request->sort === 'rating', function ($query) {
                $query->orderByDesc('reviews_avg_rating')
                      ->orderByDesc('reviews_count');
            }, function ($query) {
                $query->latest();
            })

            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('status', true)->get();

        return view('pembeli.products.index', compact(
            'products',
            'categories'
        ));
    }
}
