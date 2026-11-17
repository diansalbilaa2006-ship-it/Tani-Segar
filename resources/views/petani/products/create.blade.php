
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Tani-Segar</title>

    <style>
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

        h1 {
            color: #287443;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 17px;
            margin-bottom: 7px;
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

        .back {
            background: #777;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
        }
    </style>
</head>

<body>
<div class="container">

    <div class="card">

        <h1>Tambah Produk 🌱</h1>
        <p>Masukkan informasi produk pertanian kamu.</p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('petani.products.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <label>Nama Produk</label>
            <input type="text" name="nama_produk"
                   value="{{ old('nama_produk') }}"
                   placeholder="Contoh: Cabai Merah" required>

            <label>Kategori</label>
            <select name="category_id" required>
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old('category_id') == $category->id)>
                        {{ $category->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <label>Deskripsi Produk</label>
            <textarea name="deskripsi" rows="4"
                      placeholder="Jelaskan kondisi dan kualitas produk">{{ old('deskripsi') }}</textarea>

            <label>Harga (Rp)</label>
            <input type="number" name="harga" min="0" step="100"
                   value="{{ old('harga') }}"
                   placeholder="Contoh: 15000" required>

            <label>Stok</label>
            <input type="number" name="stok" min="0"
                   value="{{ old('stok', 0) }}" required>

            <label>Satuan</label>
            <select name="satuan" required>
                <option value="">Pilih satuan</option>
                <option value="kg">Kilogram (kg)</option>
                <option value="ikat">Ikat</option>
                <option value="buah">Buah</option>
                <option value="pack">Pack</option>
                <option value="karung">Karung</option>
            </select>

            <label>Foto Produk</label>
            <input type="file" name="gambar" accept="image/*">

            <button type="submit">Simpan Produk</button>

            <a href="{{ route('petani.products.index') }}" class="back">
                Kembali
            </a>

        </form>

    </div>
</div>
</body>
</html>
