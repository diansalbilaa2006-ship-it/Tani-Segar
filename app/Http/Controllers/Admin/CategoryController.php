<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    // Menampilkan halaman tambah kategori
    public function create()
    {
        return view('admin.categories.create');
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->only([
            'nama_kategori',
            'deskripsi',
            'status',
        ]);

        $data['slug'] = Str::slug($request->nama_kategori);

        if (Category::where('slug', $data['slug'])->exists()) {
            $data['slug'] .= '-' . Str::random(5);
        }

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Menampilkan halaman edit kategori
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Memperbarui kategori
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->only([
            'nama_kategori',
            'deskripsi',
            'status',
        ]);

        $slug = Str::slug($request->nama_kategori);

        if (Category::where('slug', $slug)
            ->where('id', '!=', $category->id)
            ->exists()) {
            $slug .= '-' . Str::random(5);
        }

        $data['slug'] = $slug;

        if ($request->hasFile('gambar')) {
            if ($category->gambar) {
                Storage::disk('public')->delete($category->gambar);
            }

            $data['gambar'] = $request->file('gambar')
                ->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    // Menghapus kategori
    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with(
                'error',
                'Kategori tidak dapat dihapus karena masih digunakan oleh produk.'
            );
        }

        if ($category->gambar) {
            Storage::disk('public')->delete($category->gambar);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
