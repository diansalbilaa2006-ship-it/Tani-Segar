
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Tani-Segar</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f8f4;
            color: #263b2e;
        }

        .navbar {
            background: #285c3b;
            color: white;
            padding: 18px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        .item {
            display: flex;
            gap: 20px;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding: 20px 0;
        }

        .item img {
            width: 110px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }

        .item-info {
            flex: 1;
        }

        .item-info h3 {
            margin-top: 0;
        }

        .price {
            color: #285c3b;
            font-weight: bold;
        }

        input[type="number"] {
            width: 75px;
            padding: 9px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        button, .btn {
            border: none;
            padding: 10px 15px;
            border-radius: 7px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
        }

        .btn-green {
            background: #285c3b;
            color: white;
        }

        .btn-red {
            background: #ffe4e4;
            color: #b52d2d;
        }

        .btn-light {
            background: #e9f0e9;
            color: #285c3b;
        }

        .total {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            color: #285c3b;
        }

        .message {
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .success {
            background: #d9f5df;
            color: #246b37;
        }

        .error {
            background: #ffe0e0;
            color: #a52828;
        }

        @media(max-width: 600px) {
            .item {
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .item img {
                width: 85px;
                height: 85px;
            }
        }
    </style>
</head>

<body>

<nav class="navbar">
    <h2>🌱 Tani-Segar</h2>

    <div>
        <a href="{{ route('pembeli.products.index') }}">Belanja</a>
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </div>
</nav>

<div class="container">

    <h1>Keranjang Belanja 🛒</h1>
    <p>Halo, {{ Auth::user()->name }}! Berikut produk pilihanmu.</p>

    @if (session('success'))
        <div class="message success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="message error">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">

        @if ($items->isEmpty())

            <h3>Keranjang masih kosong</h3>
            <p>Yuk, temukan hasil pertanian segar dari petani lokal!</p>

            <a href="{{ route('pembeli.products.index') }}"
               class="btn btn-green">
                Mulai Belanja
            </a>

        @else

            @php
                $total = 0;
            @endphp

            @foreach ($items as $item)

                @php
                    $subtotal = $item->harga * $item->jumlah;
                    $total += $subtotal;
                @endphp

                <div class="item">

                    @if ($item->product && $item->product->gambar)
                        <img
                            src="{{ asset('storage/' . $item->product->gambar) }}"
                            alt="{{ $item->product->nama_produk }}">
                    @else
                        <div style="width:110px; height:100px;
                                    background:#e9f0e9; border-radius:10px;
                                    display:flex; align-items:center;
                                    justify-content:center;">
                            🌱
                        </div>
                    @endif

                    <div class="item-info">

                        <h3>
                            {{ $item->product?->nama_produk ?? $item->nama_produk ?? 'Produk tidak tersedia' }}
                        </h3>

                        <p class="price">
                            Rp{{ number_format($item->harga, 0, ',', '.') }}
                        </p>

                        <p>
                            Subtotal:
                            Rp{{ number_format($subtotal, 0, ',', '.') }}
                        </p>

                        @if ($item->product)
                            <p>
                                Petani:
                                {{ $item->product->farmer?->nama_usaha ?? '-' }}
                            </p>
                        @endif

                    </div>

                    <div>

                        <form action="{{ route('pembeli.cart.update', $item->id) }}"
                              method="POST">
                            @csrf
                            @method('PUT')

                            <input
                                type="number"
                                name="jumlah"
                                value="{{ $item->jumlah }}"
                                min="1"
                                max="{{ $item->product?->stok ?? $item->jumlah }}"
                                required>

                            <button type="submit" class="btn-light">
                                Update
                            </button>
                        </form>

                        <form action="{{ route('pembeli.cart.destroy', $item->id) }}"
                              method="POST"
                              style="margin-top:10px;"
                              onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn-red">
                                Hapus
                            </button>
                        </form>

                    </div>

                </div>

            @endforeach

            <div class="total" style="margin-top:25px;">
                Total: Rp{{ number_format($total, 0, ',', '.') }}
            </div>

            <div style="margin-top:20px;">
                <a href="{{ route('pembeli.products.index') }}"
                   class="btn btn-light">
                    ← Lanjut Belanja
                </a>
            </div>

        @endif

    </div>

</div>

</body>
</html>
