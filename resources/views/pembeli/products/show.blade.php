
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->nama_produk }} - Tani-Segar</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f6f8f4;
            color: #26352b;
        }

        .navbar {
            background: #285c3b;
            color: white;
            padding: 18px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-size: 23px;
            font-weight: bold;
        }

        .navbar a {
            color: white;
            text-decoration: none;
        }

        .container {
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 22px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #285c3b;
            text-decoration: none;
            font-weight: bold;
        }

        .product-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 3px 14px rgba(0,0,0,0.05);
        }

        .product-image {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-radius: 12px;
            background: #e9f0e8;
        }

        .no-image {
            height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e9f0e8;
            font-size: 65px;
            border-radius: 12px;
        }

        .category {
            color: #43865a;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
        }

        h1 {
            margin: 15px 0;
            color: #285c3b;
        }

        .price {
            font-size: 26px;
            font-weight: bold;
            color: #285c3b;
            margin: 20px 0;
        }

        .description {
            line-height: 1.7;
            color: #647568;
            margin: 20px 0;
        }

        .meta {
            line-height: 2;
            color: #647568;
        }

        .btn {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 14px;
            background: #285c3b;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-top: 25px;
        }

        .section h2 {
            color: #285c3b;
            margin-bottom: 20px;
        }

        .review {
            padding: 18px 0;
            border-bottom: 1px solid #edf0ed;
        }

        .stars {
            color: #e5a500;
            margin: 8px 0;
            font-size: 18px;
        }

        .review p {
            color: #647568;
            line-height: 1.6;
        }

        .empty {
            color: #718074;
            padding: 20px 0;
        }

        .pagination {
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            padding: 25px;
            margin-top: 50px;
            background: #285c3b;
            color: white;
            font-size: 13px;
        }

.review-form {
    margin-bottom: 30px;
    padding: 20px;
    background: #f6f8f4;
    border-radius: 10px;
}

.review-form label {
    display: block;
    margin: 15px 0 8px;
    font-weight: bold;
    color: #285c3b;
}

.review-form select,
.review-form textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #d5dfd5;
    border-radius: 8px;
    font-size: 14px;
}

.review-form textarea {
    min-height: 100px;
    resize: vertical;
}

.rating-options {
    display: flex;
    gap: 12px;
    margin-top: 10px;
}

.rating-options label {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    color: #e5a500;
    font-size: 20px;
    cursor: pointer;
}

.alert-success {
    background: #dff3e3;
    color: #236b36;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.alert-error {
    background: #ffe3e3;
    color: #a52828;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.form-error {
    color: #c62828;
    font-size: 13px;
    margin-top: 5px;
}


        @media (max-width: 700px) {
            .product-detail {
                grid-template-columns: 1fr;
            }

            .product-image,
            .no-image {
                height: 250px;
            }

            .navbar {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<header class="navbar">
    <div class="brand">🌱 Tani-Segar</div>
    <a href="{{ route('pembeli.products.index') }}">Kembali ke Katalog</a>
</header>

<main class="container">

    <a href="{{ route('pembeli.products.index') }}" class="back">
        ← Kembali ke Katalog
    </a>

    <section class="product-detail">

        <div>
            @if ($product->gambar)
                <img
                    src="{{ asset('storage/' . $product->gambar) }}"
                    alt="{{ $product->nama_produk }}"
                    class="product-image"
                >
            @else
                <div class="no-image">🌾</div>
            @endif
        </div>

        <div>
            <span class="category">
                {{ $product->category?->nama_kategori ?? 'Tanpa Kategori' }}
            </span>

            <h1>{{ $product->nama_produk }}</h1>

            <div class="price">
                Rp{{ number_format($product->harga, 0, ',', '.') }}
                / {{ $product->satuan }}
            </div>

            <div class="meta">
                <div>📦 Stok: {{ $product->stok }} {{ $product->satuan }}</div>
                <div>👨‍🌾 Petani: {{ $product->farmer?->nama_usaha ?? 'Petani Tani-Segar' }}</div>
                <div>⭐ Total ulasan: {{ $product->reviews->count() }}</div>
            </div>

            <p class="description">
                {{ $product->deskripsi ?: 'Produk pertanian segar dari petani lokal.' }}
            </p>

            @if ($product->stok > 0)
                <form
                    action="{{ route('pembeli.cart.store', $product->id) }}"
                    method="POST"
                >
                    @csrf
                    <input type="hidden" name="jumlah" value="1">

                    <button type="submit" class="btn">
                        + Tambah ke Keranjang
                    </button>
                </form>
            @else
                <button class="btn" disabled style="background:#aaa;">
                    Stok Habis
                </button>
            @endif
        </div>

    </section>

    <section class="section">
        <h2>⭐ Ulasan Pembeli</h2>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert-error">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert-error">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

@if ($eligibleOrders->isNotEmpty())
    <div class="review-form">
        <h3>✍️ Berikan Ulasan Produk</h3>

        <form
            action="{{ route('pembeli.products.reviews.store', $product->id) }}"
            method="POST"
        >
            @csrf

            <label for="order_id">Pilih Pesanan</label>

            <select name="order_id" id="order_id" required>
                <option value="">-- Pilih pesanan --</option>

                @foreach ($eligibleOrders as $order)
                    <option
                        value="{{ $order->id }}"
                        {{ old('order_id') == $order->id ? 'selected' : '' }}
                    >
                        {{ $order->kode_pesanan }}
                    </option>
                @endforeach
            </select>

            <label>Berikan Rating</label>

            <div class="rating-options">
                @for ($i = 1; $i <= 5; $i++)
                    <label>
                        <input
                            type="radio"
                            name="rating"
                            value="{{ $i }}"
                            {{ old('rating') == $i ? 'checked' : '' }}
                            required
                        >
                        {{ $i }} ★
                    </label>
                @endfor
            </div>

            <label for="komentar">Komentar</label>

            <textarea
                name="komentar"
                id="komentar"
                placeholder="Bagaimana kualitas produk yang kamu beli?"
            >{{ old('komentar') }}</textarea>

            <button type="submit" class="btn">
                Kirim Ulasan
            </button>
        </form>
    </div>
@elseif (auth()->check())
    <p class="empty">
        Belum ada pesanan selesai yang bisa diulas untuk produk ini.
    </p>
@endif


        @forelse ($reviews as $review)
            <div class="review">
                <strong>{{ $review->user?->name ?? 'Pembeli' }}</strong>

                <div class="stars">
                    @for ($i = 1; $i <= 5; $i++)
                        {{ $i <= $review->rating ? '★' : '☆' }}
                    @endfor
                </div>

                <p>{{ $review->komentar ?: 'Tidak ada komentar.' }}</p>

                <small>
                    {{ $review->created_at->format('d M Y') }}
                </small>
            </div>
        @empty
            <p class="empty">Belum ada ulasan untuk produk ini.</p>
        @endforelse

        <div class="pagination">
            {{ $reviews->links() }}
        </div>
    </section>

</main>

<footer class="footer">
    © {{ date('Y') }} Tani-Segar. Mendukung Petani Lokal Indonesia.
</footer>

</body>
</html>
