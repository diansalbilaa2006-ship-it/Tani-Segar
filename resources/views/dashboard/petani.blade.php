
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petani - Tani-Segar</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f7f2;
            color: #26352b;
        }

        .navbar {
            background: #285c3b;
            color: white;
            padding: 20px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            font-size: 23px;
        }

        .logout button {
            background: white;
            color: #285c3b;
            border: none;
            padding: 10px 18px;
            border-radius: 7px;
            cursor: pointer;
            font-weight: bold;
        }

        .container {
            max-width: 1150px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            margin-bottom: 8px;
        }

        .welcome p {
            color: #68766c;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
            border-left: 5px solid #43865a;
        }

        .card p {
            color: #68766c;
            margin-bottom: 12px;
        }

        .card h2 {
            font-size: 30px;
            color: #285c3b;
        }

        .section {
            margin-top: 30px;
            background: white;
            padding: 25px;
            border-radius: 12px;
        }

        .section h2 {
            margin-bottom: 10px;
        }

        .section p {
            color: #68766c;
            margin-bottom: 20px;
        }

        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            background: #285c3b;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 7px;
        }

        .btn.secondary {
            background: #e5efe7;
            color: #285c3b;
        }

        @media (max-width: 700px) {
            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>🌱 Tani-Segar | Petani</h2>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    <div class="container">

        <div class="welcome">
            <h1>Dashboard Petani</h1>
            <p>Selamat datang, {{ $user->name }}! Kelola produk dan pesanan hasil pertanianmu.</p>
        </div>

        <div class="stats">

            <div class="card">
                <p>Total Produk</p>
                <h2>{{ $stats['total_produk'] }}</h2>
            </div>

            <div class="card">
                <p>Total Pesanan</p>
                <h2>{{ $stats['total_pesanan'] }}</h2>
            </div>

            <div class="card">
                <p>Produk Stok Habis</p>
                <h2>{{ $stats['produk_habis'] }}</h2>
            </div>

        </div>

        <div class="section">
            <h2>Kelola Produk</h2>
            <p>
                Tambahkan produk pertanian, atur harga dan stok,
                serta perbarui informasi produk yang dijual.
            </p>

            <div class="actions">
                <a href="{{ route('petani.products.index') }}" class="btn">
                    Lihat Produk Saya
                </a>

                <a href="{{ route('petani.products.create') }}" class="btn secondary">
                    + Tambah Produk
                </a>
            </div>
        </div>

        <div class="section">
    <h2>Informasi Pesanan</h2>
    <p>
        Lihat pesanan yang masuk, periksa detail pesanan,
        dan perbarui status pengiriman produk kepada pembeli.
    </p>

    <div class="actions">
        <a href="{{ route('petani.orders.index') }}" class="btn">
            📦 Lihat Pesanan Masuk
        </a>
    </div>
</div>

    </div>

</body>
</html>
