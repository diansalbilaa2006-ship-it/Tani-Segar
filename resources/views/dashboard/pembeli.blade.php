
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pembeli | Tani-Segar</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f8f2;
            color: #263b2c;
        }

        header {
            background: #245c3b;
            color: white;
            padding: 20px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        header h2 {
            margin: 0;
        }

        .logout {
            background: white;
            color: #245c3b;
            border: none;
            padding: 10px 18px;
            border-radius: 7px;
            cursor: pointer;
            font-weight: bold;
        }

        .container {
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .welcome {
            background: white;
            padding: 28px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px #0000000a;
        }

        .welcome h1 {
            margin-top: 0;
            color: #245c3b;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 10px #0000000a;
        }

        .stat-card p {
            color: #718078;
            margin-bottom: 8px;
        }

        .stat-card h2 {
            margin: 0;
            color: #245c3b;
            font-size: 30px;
        }

        .menu-title {
            margin-bottom: 18px;
        }

        .menus {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .menu-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-decoration: none;
            color: #263b2c;
            box-shadow: 0 2px 10px #0000000a;
            transition: 0.2s;
        }

        .menu-card:hover {
            transform: translateY(-4px);
        }

        .menu-card h3 {
            color: #245c3b;
            margin-top: 0;
        }

        .menu-card p {
            color: #718078;
            line-height: 1.5;
        }

        footer {
            text-align: center;
            padding: 25px;
            color: #718078;
        }
    </style>
</head>

<body>

<header>
    <h2>🌱 Tani-Segar | Pembeli</h2>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout">Logout</button>
    </form>
</header>

<div class="container">

    <section class="welcome">
        <h1>Selamat Datang, {{ $user->name }}! 👋</h1>
        <p>
            Selamat berbelanja di Tani-Segar.
            Temukan hasil pertanian segar langsung dari petani lokal.
        </p>
    </section>

    <section class="stats">

        <div class="stat-card">
            <p>Total Pesanan</p>
            <h2>{{ $stats['total_pesanan'] ?? 0 }}</h2>
        </div>

        <div class="stat-card">
            <p>Jumlah Produk di Keranjang</p>
            <h2>{{ $stats['jumlah_keranjang'] ?? 0 }}</h2>
        </div>

    </section>

    <h2 class="menu-title">Menu Belanja</h2>

    <section class="menus">

        <a href="{{ route('pembeli.products.index') }}" class="menu-card">
            <h3>🛍️ Katalog Produk</h3>
            <p>Lihat dan temukan berbagai hasil pertanian segar.</p>
        </a>

        <a href="{{ route('pembeli.cart.index') }}" class="menu-card">
            <h3>🛒 Keranjang Saya</h3>
            <p>Lihat dan kelola produk yang ingin dibeli.</p>
        </a>

        <a href="{{ route('pembeli.orders.index') }}" class="menu-card">
            <h3>📦 Riwayat Pesanan</h3>
            <p>Pantau status dan riwayat transaksi belanja.</p>
        </a>

    </section>

</div>

<footer>
    © {{ date('Y') }} Tani-Segar. Belanja Segar, Langsung dari Petani.
</footer>

</body>
</html>
