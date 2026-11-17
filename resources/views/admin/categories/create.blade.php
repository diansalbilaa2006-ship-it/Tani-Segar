
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori - Tani-Segar</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f5f8f4;
            color: #26352b;
        }

        .container {
            max-width: 650px;
            margin: auto;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #38734a;
            text-decoration: none;
            font-weight: bold;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 12px;
            box-shadow: 0 3px 15px #0000000d;
        }

        h1 { margin-top: 0; }

        label {
            display: block;
            margin: 18px 0 7px;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d7dfd7;
            border-radius: 7px;
            font-size: 14px;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .error {
            color: #c0392b;
            font-size: 13px;
            margin-top: 5px;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        button, .cancel {
            padding: 12px 18px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        button {
            background: #34784b;
            color: white;
        }

        .cancel {
            background: #e8ece8;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">

    <a href="{{ route('admin.categories.index') }}" class="back">
        ← Kembali ke Kategori
    </a>

    <div class="card">
        <h1>Tambah Kategori</h1>
        <p>Masukkan informasi kategori produk baru.</p>

        @if($errors->any())
            <div class="error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('admin.categories.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <label>Nama Kategori</label>
            <input
                type="text"
                name="nama_kategori"
                value="{{ old('nama_kategori') }}"
                placeholder="Contoh: Sayuran"
                required
            >

            @error('nama_kategori')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Deskripsi</label>
            <textarea
                name="deskripsi"
                placeholder="Masukkan deskripsi kategori..."
            >{{ old('deskripsi') }}</textarea>

            <label>Gambar Kategori</label>
            <input
                type="file"
                name="gambar"
                accept="image/jpeg,image/png,image/webp"
            >

            @error('gambar')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Status</label>
            <select name="status" required>
                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>

            <div class="buttons">
                <button type="submit">Simpan Kategori</button>

                <a href="{{ route('admin.categories.index') }}" class="cancel">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>

</body>
</html>
