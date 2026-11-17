
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Tani-Segar</title>

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
            flex-wrap: wrap;
            gap: 15px;
        }

        .brand {
            font-size: 23px;
            font-weight: bold;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-right a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .logout button {
            background: white;
            color: #285c3b;
            border: none;
            padding: 9px 16px;
            border-radius: 7px;
            cursor: pointer;
            font-weight: bold;
        }

        .container {
            max-width: 1200px;
            margin: 35px auto;
            padding: 0 22px;
        }

        .hero {
            background: #e5efe5;
            border-radius: 16px;
            padding: 35px;
            margin-bottom: 30px;
        }

        .hero h1 {
            color: #285c3b;
            font-size: 30px;
            margin-bottom: 12px;
        }

        .hero p {
            color: #647568;
            line-height: 1.6;
        }

        .filter-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.04);
        }

        .filter-box h3 {
            margin-bottom: 15px;
        }

        .filter-form {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-form input,
        .filter-form select {
            padding: 13px;
            border: 1px solid #dce4dc;
            border-radius: 8px;
            background: white;
            outline: none;
        }

        .filter-form input {
            flex: 1;
            min-width: 200px;
        }

        .filter-form select {
            min-width: 180px;
        }

        .btn-search {
            background: #285c3b;
            color: white;
            border: none;
            padding: 13px 22px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-reset {
            background: #edf2ed;
            color: #285c3b;
            padding: 13px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
        }

        .section-heading h2 {
            color: #285c3b;
        }

        .section-heading span {
            color: #718074;
            font-size: 14px;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .product-card {
            background: white;
            border-radius: 13px;
            overflow: hidden;
            box-shadow: 0 3px 14px rgba(0,0,0,0.05);
            transition: 0.2s;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.09);
        }

        .product-image {
            width: 100%;
            height: 190px;
            object-fit: cover;
            background: #e9f0e8;
        }

        .no-image {
            height: 190px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e9f0e8;
            color: #829184;
            font-size: 45px;
        }

        .product-info {
            padding: 17px;
        }

        .category {
            color: #43865a;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .product-info h3 {
            margin: 9px 0;
            font-size: 18px;
        }

        .description {
            color: #718074;
            font-size: 13px;
            line-height: 1.5;
            min-height: 38px;
            margin-bottom: 12px;
        }

        .price {
            color: #285c3b;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .rating {
            margin-bottom: 12px;
            color: #e5a500;
            font-size: 14px;
        }

        .rating-count {
            color: #718074;
            font-size: 12px;
        }

        .product-meta {
            border-top: 1px solid #edf0ed;
            padding-top: 12px;
            color: #718074;
            font-size: 12px;
            line-height: 1.8;
        }

        .empty {
            grid-column: 1 / -1;
            background: white;
            padding: 55px 20px;
            text-align: center;
            border-radius: 13px;
        }

        .empty h3 {
            color: #285c3b;
            margin-bottom: 10px;
        }

        .empty p {
            color: #718074;
        }

        .pagination {
            margin-top: 30px;
        }

        .footer {
            text-align: center;
            padding: 25px;
            margin-top: 50px;
            background: #285c3b;
            color: white;
            font-size: 13px;
        }

        @media (max-width: 950px) {
            .products {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 700px) {
            .products {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero h1 {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .products {
                grid-template-columns: 1fr;
            }

            .filter-form {
                flex-direction: column;
            }

            .filter-form input,
            .filter-form select,
            .filter-form button {
                width: 100%;
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

        <div class="nav-right">
            <a href="{{ route('dashboard') }}">Dashboard</a>

            <form action="{{ route('logout') }}" method="POST" class="logout">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </header>

    <main class="container">

        @if (session('success'))
            <div style="background: #d9f5df; color: #246b37;
                        padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="background: #ffe0e0; color: #a52828;
                        padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <section class="hero">
            <h1>Belanja Hasil Pertanian Segar 🌿</h1>
            <p>
                Selamat datang, {{ Auth::user()->name }}!
                Temukan berbagai hasil pertanian berkualitas
                langsung dari petani lokal.
            </p>
        </section>

        <section class="filter-box">
            <h3>Temukan Produk</h3>

            <form action="{{ route('pembeli.products.index') }}"
                  method="GET"
                  class="filter-form">

                <input
                    type="text"
                    name="search"
                    placeholder="Cari nama produk..."
                    value="{{ request('search') }}"
                >

                <select name="category">
                    <option value="">Semua Kategori</option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ request('category') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->nama_kategori }}
                        </option>
                    @endforeach
                </select>

                <!-- Pengurutan Produk -->
                <select name="sort">
                    <option value="">Produk Terbaru</option>
                    <option value="rating"
                        {{ request('sort') == 'rating' ? 'selected' : '' }}>
                        Rating Tertinggi
                    </option>
                </select>

                <button type="submit" class="btn-search">
                    Cari Produk
                </button>

                <a href="{{ route('pembeli.products.index') }}"
                   class="btn-reset">
                    Reset
                </a>

            </form>
        </section>

        <div class="section-heading">
            <h2>Produk Pilihan</h2>
            <span>{{ $products->total() }} produk ditemukan</span>
        </div>

        <section class="products">

            @forelse ($products as $product)

                <article class="product-card">

                    @if ($product->gambar)
                        <img
                            src="{{ asset('storage/' . $product->gambar) }}"
                            alt="{{ $product->nama_produk }}"
                            class="product-image"
                        >
                    @else
                        <div class="no-image">🌾</div>
                    @endif

                    <div class="product-info">

                        <span class="category">
                            {{ $product->category?->nama_kategori ?? 'Tanpa Kategori' }}
                        </span>

                        <h3>{{ $product->nama_produk }}</h3>

                        <p class="description">
                            {{ $product->deskripsi ?: 'Produk pertanian segar dari petani lokal.' }}
                        </p>

                        <div class="price">
                            Rp{{ number_format($product->harga, 0, ',', '.') }}
                            <small style="font-size: 12px; font-weight: normal;">
                                / {{ $product->satuan }}
                            </small>
                        </div>

                        <div class="rating">
                            @if ($product->reviews_count > 0)
                                ⭐ {{ number_format($product->reviews_avg_rating, 1) }}
                                <span class="rating-count">
                                    ({{ $product->reviews_count }} ulasan)
                                </span>
                            @else
                                <span class="rating-count">☆ Belum ada ulasan</span>
                            @endif
                        </div>

                        <div class="product-meta">
                            <div>
                                📦 Stok: {{ $product->stok }} {{ $product->satuan }}
                            </div>

                            <div>
                                👨‍🌾 Petani:
                                {{ $product->farmer?->nama_usaha ?? 'Petani Tani-Segar' }}
                            </div>
                        </div>

                        <a href="{{ route('pembeli.products.show', $product->id) }}"
                           style="display:block; margin-top:15px; margin-bottom:10px;
                                  color:#285c3b; font-weight:bold; text-decoration:none;">
                            Lihat Detail & Ulasan
                        </a>

                        @if ($product->stok > 0)
                            <form action="{{ route('pembeli.cart.store', $product->id) }}"
                                  method="POST">
                                @csrf

                                <input type="hidden" name="jumlah" value="1">

                                <button type="submit"
                                        style="width:100%; padding:12px; border:none;
                                               border-radius:8px; background:#285c3b;
                                               color:white; font-weight:bold; cursor:pointer;">
                                    + Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <button disabled
                                    style="width:100%; padding:12px; margin-top:15px;
                                           border:none; border-radius:8px;
                                           background:#aaa; color:white;">
                                Stok Habis
                            </button>
                        @endif

                    </div>
                </article>

            @empty

                <div class="empty">
                    <h3>🌱 Produk Belum Tersedia</h3>
                    <p>
                        Belum ada produk yang sesuai dengan pencarian kamu.
                        Coba kata kunci atau kategori lainnya.
                    </p>
                </div>

            @endforelse

        </section>

        <div class="pagination">
            {{ $products->links() }}
        </div>

    </main>

    <footer class="footer">
        © {{ date('Y') }} Tani-Segar. Mendukung Petani Lokal Indonesia.
    </footer>

</body>
</html>
