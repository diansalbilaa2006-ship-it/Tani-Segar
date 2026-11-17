
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Tani-Segar</title>

    <style>
        * { box-sizing: border-box; }

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
        }

        .navbar h2 { margin: 0; }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .layout {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 25px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        label {
            display: block;
            font-weight: bold;
            margin: 15px 0 7px;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #dce5dc;
            border-radius: 8px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        .product {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .product img {
            width: 75px;
            height: 75px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-info { flex: 1; }

        .product-info h4 { margin: 5px 0; }

        .price {
            color: #285c3b;
            font-weight: bold;
        }

        .total {
            display: flex;
            justify-content: space-between;
            font-size: 20px;
            font-weight: bold;
            color: #285c3b;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-green {
            background: #285c3b;
            color: white;
        }

        .btn-light {
            background: #e9f0e9;
            color: #285c3b;
        }

        .btn:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        @media(max-width: 750px) {
            .layout { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

<nav class="navbar">
    <h2>🌱 Tani-Segar</h2>
</nav>

<div class="container">

    @if ($errors->any())
    <div style="background:#ffe5e5;color:#a00000;padding:15px;border-radius:8px;margin-bottom:20px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <h1>Checkout Pesanan 🛒</h1>
    <p>Lengkapi informasi pengiriman sebelum membuat pesanan.</p>

   
<form action="{{ route('pembeli.checkout.store') }}" method="POST">
    @csrf

    <div class="layout">

        <!-- Kolom kiri -->
        <div>

            <div class="card">
                <h2>Informasi Pengiriman</h2>

                <label>Nama Penerima</label>
                <input type="text"
                       value="{{ Auth::user()->name }}"
                       readonly>

                <label>Nomor Telepon</label>
                <input type="text"
                       name="no_telepon"
                       value="{{ old('no_telepon') }}"
                       placeholder="Masukkan nomor telepon"
                       required>

                <label>Alamat Pengiriman</label>
                <textarea name="alamat_pengiriman"
                          placeholder="Masukkan alamat lengkap"
                          required>{{ old('alamat_pengiriman') }}</textarea>

                <label>Catatan (Opsional)</label>
                <textarea name="catatan"
                          placeholder="Contoh: Rumah pagar hijau">{{ old('catatan') }}</textarea>
            </div>

            <div class="card">
                <h2>Metode Pembayaran</h2>

                <label>
                    <input type="radio"
                           name="metode_pembayaran"
                           value="transfer"
                           style="width:auto;"
                           {{ old('metode_pembayaran') == 'transfer' ? 'checked' : '' }}
                           required>
                    Transfer Bank
                </label>

                <label>
                    <input type="radio"
                           name="metode_pembayaran"
                           value="cod"
                           style="width:auto;"
                           {{ old('metode_pembayaran') == 'cod' ? 'checked' : '' }}>
                    Bayar di Tempat (COD)
                </label>
            </div>

        </div>

        <!-- Kolom kanan -->
        <div class="card">
            <h2>Ringkasan Pesanan</h2>

            @foreach ($items as $item)
                <div class="product">

                    @if ($item->product?->gambar)
                        <img
                            src="{{ asset('storage/' . $item->product->gambar) }}"
                            alt="{{ $item->product->nama_produk }}">
                    @else
                        <div style="width:75px;height:75px;
                                    background:#e9f0e9;
                                    display:grid;place-items:center;">
                            🌱
                        </div>
                    @endif

                    <div class="product-info">
                        <h4>
                            {{ $item->product?->nama_produk ?? 'Produk tidak tersedia' }}
                        </h4>

                        <p>
                            {{ $item->jumlah }} x
                            Rp{{ number_format($item->harga, 0, ',', '.') }}
                        </p>

                        <p class="price">
                            Rp{{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}
                        </p>
                    </div>

                </div>
            @endforeach

            <div class="total">
                <span>Total Belanja</span>
                <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <p style="color:#777;font-size:13px;">
                Biaya pengiriman akan dihitung pada tahap berikutnya.
            </p>

            <button type="submit"
                    class="btn btn-green"
                    style="width:100%;margin-top:15px;">
                Konfirmasi Pesanan
            </button>

            <a href="{{ route('pembeli.cart.index') }}"
               class="btn btn-light"
               style="width:100%;text-align:center;margin-top:10px;">
                Kembali ke Keranjang
            </a>
        </div>

    </div>
</form>

</div>

</body>
</html>
