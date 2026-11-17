<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    // Mengambil data petani yang sedang login
    private function farmer()
    {
        return Auth::user()->farmer;
    }

    // Menampilkan produk milik petani
    public function index()
    {
        $products = Product::where('farmer_id', $this->farmer()->id)
            ->with('category')
            ->latest()
            ->get();

        return view('petani.products.index', compact('products'));
    }

    // Form tambah produk
    public function create()
    {
        $categories = Category::where('status', true)->get();

        return view('petani.products.create', compact('categories'));
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'nama_produk' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:30'],
            'gambar' => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['farmer_id'] = $this->farmer()->id;
        $validated['slug'] = Str::slug($validated['nama_produk'])
            . '-' . Str::lower(Str::random(6));

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')
                ->store('produk', 'public');
        }

        $validated['status'] = $validated['stok'] > 0
            ? 'aktif'
            : 'habis';

        Product::create($validated);

        return redirect()->route('petani.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    // Form edit produk
    public function edit($id)
    {
        $product = Product::where('farmer_id', $this->farmer()->id)
            ->findOrFail($id);

        $categories = Category::where('status', true)->get();

        return view('petani.products.edit', compact('product', 'categories'));
    }

    // Memperbarui produk
    public function update(Request $request, $id)
    {
        $product = Product::where('farmer_id', $this->farmer()->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'nama_produk' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:30'],
            'gambar' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }

            $validated['gambar'] = $request->file('gambar')
                ->store('produk', 'public');
        }

        $validated['status'] = $validated['stok'] > 0
            ? 'aktif'
            : 'habis';

        $product->update($validated);

        return redirect()->route('petani.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $product = Product::where('farmer_id', $this->farmer()->id)
            ->findOrFail($id);

        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->route('petani.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
