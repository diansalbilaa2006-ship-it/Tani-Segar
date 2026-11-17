
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Tani-Segar</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f8f4;
            color: #263528;
        }

        .navbar {
            background: #244d35;
            color: white;
            padding: 18px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 18px;
        }

        .container {
            max-width: 1050px;
            margin: 35px auto;
            padding: 0 20px;
        }

        h1 { margin-bottom: 8px; }

        .subtitle { color: #718071; margin-bottom: 25px; }

        .order-card {
            background: white;
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 18px;
            box-shadow: 0 3px 12px rgba(0,0,0,.05);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .muted { color: #788278; font-size: 13px; }

        .status {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 20px;
            background: #fff2cf;
            color: #916400;
            font-size: 12px;
            font-weight: bold;
        }

        .order-info {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            margin: 18px 0;
        }

        .total { font-weight: bold; color: #244d35; }

        .btn {
            display: inline-block;
            background: #244d35;
            color: white;
            padding: 10px 16px;
            border-radius: 7px;
            text-decoration: none;
            font-size: 13px;
        }

        .empty {
            background: white;
            padding: 50px 20px;
            text-align: center;
            border-radius: 12px;
        }

        .pagination { margin-top: 20px; }

        @media(max-width:600px) {
            .navbar { padding: 16px 5%; }
            .container { margin-top: 25px; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <strong>🌱 Tani-Segar</strong>
    <div>
        <a href="{{ route('pembeli.products.index') }}">Produk</a>
        <a href="{{ route('pembeli.cart.index') }}">Keranjang</a>
        <a href="{{ route('pembeli.orders.index') }}">Pesanan</a>
    </div>
</nav>

<div class="container">

    <h1>Riwayat Pesanan</h1>
    <p class="subtitle">Lihat dan pantau semua pesanan belanja kamu.</p>

    @if(session('success'))
        <div style="background:#dff5e3;color:#236b35;padding:13px;border-radius:8px;margin-bottom:18px;">
            {{ session('success') }}
        </div>
    @endif

    @forelse($orders as $order)
        <div class="order-card">

            <div class="order-header">
                <div>
                    <strong>{{ $order->kode_pesanan }}</strong>
                    <p class="muted">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                </div>

                <span class="status">
                    {{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}
                </span>
            </div>

            <div class="order-info">
                <div>
                    <div class="muted">Petani</div>
                    <strong>{{ $order->farmer->nama_usaha ?? 'Petani' }}</strong>
                </div>

                <div>
                    <div class="muted">Jumlah produk</div>
                    <strong>{{ $order->items->sum('jumlah') }} item</strong>
                </div>

                <div>
                    <div class="muted">Metode pembayaran</div>
                    <strong>{{ strtoupper($order->metode_pembayaran) }}</strong>
                </div>

                <div>
                    <div class="muted">Total pesanan</div>
                    <div class="total">
                        Rp{{ number_format($order->total_harga, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <a href="{{ route('pembeli.orders.show', $order->id) }}" class="btn">
                Lihat Detail
            </a>

        </div>
    @empty
        <div class="empty">
            <h2>Belum Ada Pesanan</h2>
            <p>Kamu belum memiliki riwayat pesanan.</p>
            <a href="{{ route('pembeli.products.index') }}" class="btn">
                Mulai Belanja
            </a>
        </div>
    @endforelse

    <div class="pagination">
        {{ $orders->links() }}
    </div>

</div>

</body>
</html>
