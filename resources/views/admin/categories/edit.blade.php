
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - Tani-Segar</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f5f8f4;
            color: #263326;
        }
        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,.06);
        }
        h1 { margin-top: 0; }
        label {
            display: block;
            margin: 18px 0 8px;
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 14px;
        }
        textarea { min-height: 100px; resize: vertical; }
        button {
            margin-top: 22px;
            padding: 12px 20px;
            border: none;
            border-radius: 7px;
            background: #287a3d;
            color: white;
            cursor: pointer;
        }
        .back { color: #287a3d; text-decoration: none; }
        .error { color: #c62828; font-size: 13px; margin-top: 5px; }
        .current-image { width: 100px; margin-top: 10px; border-radius: 8px; }
    </style>
</head>
<body>
<div class="container">
    <a class="back" href="{{ route('admin.categories.index') }}">← Kembali</a>

    <h1>Edit Kategori</h1>
    <p>Perbarui informasi kategori produk.</p>

    @if ($errors->any())
        <div class="error">
            Periksa kembali data yang kamu masukkan.
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category->id) }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori"
               value="{{ old('nama_kategori', $category->nama_kategori) }}" required>
        @error('nama_kategori')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Deskripsi</label>
        <textarea name="deskripsi">{{ old('deskripsi', $category->deskripsi) }}</textarea>
        @error('deskripsi')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Gambar Kategori</label>
        <input type="file" name="gambar" accept="image/*">
        @if ($category->gambar)
            <p>Gambar saat ini:</p>
            <img class="current-image"
                 src="{{ asset('storage/' . $category->gambar) }}"
                 alt="Gambar kategori">
        @endif
        @error('gambar')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Status</label>
        <select name="status" required>
            <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }}>Nonaktif</option>
        </select>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>
