
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Saya - Tani-Segar</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f3f7f0;
            color: #263b2c;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 {
            color: #287443;
            margin-bottom: 8px;
        }

        .btn {
            display: inline-block;
            padding: 11px 17px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-add {
            background: #287443;
        }

        .btn-edit {
            background: #d69e27;
        }

        .btn-delete {
            background: #dc2626;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 18px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .product {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .product img {
            width: 130px;
            height: 110px;
            object-fit: cover;
            border-radius: 10px;
            background: #eee;
        }

        .product-info {
            flex: 1;
        }

        .product-info h3 {
            margin-top: 0;
        }

        .price {
            color: #287443;
            font-weight: bold;
        }

        .status {
            font-weight: bold;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 12px;
        }

        .empty {
            text-align: center;
            padding: 50px 20px;
            color: #777;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .product {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <div>
            <h1>Produk Saya 🌱</h1>
            <p>Kelola produk hasil pertanian kamu di Tani-Segar.</p>
        </div>

        <a href="{{ route('petani.products.create') }}" class="btn btn-add">
            + Tambah Produk
        </a>
    </div>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($products as $product)

        <div class="card">
            <div class="product">

                @if ($product->gambar)
                    <img src="{{ asset('storage/' . $product->gambar) }}"
                         alt="{{ $product->nama_produk }}">
                @else
                    <img src="https://placehold.co/130x110?text=Produk"
                         alt="Foto produk">
                @endif

                <div class="product-info">

                    <h3>{{ $product->nama_produk }}</h3>

                    <p>
                        Kategori:
                        {{ $product->category->nama_kategori }}
                    </p>

                    <p class="price">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                        / {{ $product->satuan }}
                    </p>

                    <p>Stok: {{ $product->stok }} {{ $product->satuan }}</p>

                    <p>
                        Status:
                        <span class="status">
                            {{ ucfirst($product->status) }}
                        </span>
                    </p>

                    <div class="actions">

                        <a href="{{ route('petani.products.edit', $product->id) }}"
                           class="btn btn-edit">
                            Edit
                        </a>

                        <form action="{{ route('petani.products.destroy', $product->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-delete">
                                Hapus
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        </div>

    @empty

        <div class="card empty">
            <h3>Belum Ada Produk</h3>
            <p>Silakan tambahkan produk pertanian pertama kamu.</p>
        </div>

    @endforelse

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-delete" type="submit">Logout</button>
    </form>

</div>
</body>
</html>
