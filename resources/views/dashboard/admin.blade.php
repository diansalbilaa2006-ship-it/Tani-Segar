
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Tani-Segar</title>

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

        /* Navbar */
        .navbar {
            background: #285c3b;
            color: white;
            padding: 20px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
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

        .logout button:hover {
            background: #e9f2e9;
        }

        /* Container */
        .container {
            max-width: 1150px;
            margin: 35px auto;
            padding: 0 20px;
        }

        /* Welcome */
        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            margin-bottom: 8px;
            font-size: 28px;
        }

        .welcome p {
            color: #68766c;
            line-height: 1.6;
        }

        /* Statistik */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
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
            font-size: 14px;
        }

        .card h2 {
            font-size: 30px;
            color: #285c3b;
        }

        /* Menu */
        .menu-title {
            margin-top: 38px;
            margin-bottom: 18px;
            font-size: 22px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.04);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .section h2 {
            margin-bottom: 12px;
            font-size: 20px;
        }

        .section p {
            color: #68766c;
            line-height: 1.6;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        /* Tombol */
        .btn {
            display: inline-block;
            background: #285c3b;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 7px;
            font-weight: bold;
            transition: 0.2s;
        }

        .btn:hover {
            background: #19452b;
            transform: translateY(-2px);
        }

        /* Footer */
        .footer {
            text-align: center;
            color: #7a887d;
            font-size: 13px;
            padding: 30px 15px;
        }

        /* Responsive */
        @media (max-width: 800px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .menu-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 500px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .navbar {
                padding: 18px;
            }

            .navbar h2 {
                font-size: 18px;
            }

            .welcome h1 {
                font-size: 23px;
            }

            .container {
                margin-top: 25px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <div class="navbar">
        <h2>🌱 Tani-Segar | Admin</h2>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    <div class="container">

        <!-- Sambutan -->
        <div class="welcome">
            <h1>Dashboard Admin</h1>
            <p>
                Selamat datang, {{ $user->name }}!
                Kelola aktivitas Tani-Segar di sini.
            </p>
        </div>

        <!-- Statistik -->
        <div class="stats">

            <div class="card">
                <p>Total Pengguna</p>
                <h2>{{ $stats['total_pengguna'] }}</h2>
            </div>

            <div class="card">
                <p>Calon Petani Menunggu</p>
                <h2>{{ $stats['calon_petani'] }}</h2>
            </div>

            <div class="card">
                <p>Total Produk</p>
                <h2>{{ $stats['total_produk'] }}</h2>
            </div>

            <div class="card">
                <p>Total Pesanan</p>
                <h2>{{ $stats['total_pesanan'] }}</h2>
            </div>

        </div>

        <!-- Menu Pengelolaan -->
        <h2 class="menu-title">Pengelolaan Tani-Segar</h2>

        <div class="menu-grid">

            <!-- Verifikasi Calon Petani -->
            <div class="section">
                <h2>👨‍🌾 Verifikasi Calon Petani</h2>
                <p>
                    Periksa data pendaftaran calon petani dan tentukan
                    apakah pendaftar dapat menjadi petani di Tani-Segar.
                </p>

                <a href="{{ route('admin.farmers.index') }}" class="btn">
                    Kelola Calon Petani →
                </a>
            </div>

            <!-- Verifikasi Pembayaran -->
            <div class="section">
                <h2>💳 Verifikasi Pembayaran</h2>
                <p>
                    Periksa bukti pembayaran yang telah diunggah pembeli.
                    Admin dapat menyetujui atau menolak pembayaran.
                </p>

                <a href="{{ route('admin.payments.index') }}" class="btn">
                    Kelola Pembayaran →
                </a>
            </div>

            <!-- Kelola Pesanan -->
            <div class="section">
                <h2>📦 Kelola Pesanan</h2>
                <p>
                    Pantau seluruh transaksi pembeli, informasi produk,
                    status pembayaran, dan proses pengiriman pesanan.
                </p>

                <a href="{{ route('admin.orders.index') }}" class="btn">
                    Lihat Semua Pesanan →
                </a>
            </div>

            <!-- Kelola Kategori -->
            <div class="section">
                <h2>📂 Kelola Kategori</h2>
                <p>
                    Tambah, edit, dan hapus kategori produk
                    yang tersedia di Tani-Segar.
                </p>

                <a href="{{ route('admin.categories.index') }}" class="btn">
                    Kelola Kategori →
                </a>
            </div>

        </div>

    </div>

    <!-- Footer -->
    <div class="footer">
        © 2026 Tani-Segar. Sistem Informasi E-Commerce Hasil Pertanian.
    </div>

</body>
</html>
