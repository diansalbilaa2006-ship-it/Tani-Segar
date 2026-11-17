
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Tani-Segar</title>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #f3f7f0;
            padding: 30px;
            color: #263b2c;
        }

        .container {
            max-width: 650px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        h1 { color: #287443; }

        label {
            display: block;
            font-weight: bold;
            margin: 17px 0 7px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        button, .back {
            display: inline-block;
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            color: white;
            background: #287443;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px;
        }

        .back { background: #777; }

        .error { color: #dc2626; }

        .preview {
            width: 150px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="card">

        <h1>Edit Produk 🌱</h1>
        <p>Perbarui informasi produk pertanian kamu.</p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('petani.products.update', $product->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <label>Nama Produk</label>
            <input type="text" name="nama_produk"
                   value="{{ old('nama_produk', $product->nama_produk) }}"
                   required>

            <label>Kategori</label>
            <select name="category_id" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old('category_id', $product->category_id) == $category->id)>
                        {{ $category->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4">{{ old('deskripsi', $product->deskripsi) }}</textarea>

            <label>Harga (Rp)</label>
            <input type="number" name="harga" min="0" step="100"
                   value="{{ old('harga', $product->harga) }}" required>

            <label>Stok</label>
            <input type="number" name="stok" min="0"
                   value="{{ old('stok', $product->stok) }}" required>

            <label>Satuan</label>
            <select name="satuan" required>
                @foreach (['kg', 'ikat', 'buah', 'pack', 'karung'] as $satuan)
                    <option value="{{ $satuan }}"
                        @selected(old('satuan', $product->satuan) == $satuan)>
                        {{ ucfirst($satuan) }}
                    </option>
                @endforeach
            </select>

            <label>Foto Produk Saat Ini</label>

            @if ($product->gambar)
                <img class="preview"
                     src="{{ asset('storage/' . $product->gambar) }}"
                     alt="Foto {{ $product->nama_produk }}">
            @else
                <p>Belum ada foto produk.</p>
            @endif

            <label>Ganti Foto Produk (Opsional)</label>
            <input type="file" name="gambar" accept="image/*">

            <button type="submit">Simpan Perubahan</button>

            <a href="{{ route('petani.products.index') }}" class="back">
                Kembali
            </a>

        </form>
    </div>
</div>
</body>
</html>
