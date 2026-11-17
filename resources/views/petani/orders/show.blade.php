
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Tani-Segar</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f5f8f4;
            color: #26352b;
        }

        .navbar {
            background: #285c3b;
            color: white;
            padding: 20px 35px;
        }

        .container {
            max-width: 1000px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,.05);
        }

        h1 { margin-bottom: 8px; }

        h2 {
            margin-bottom: 18px;
            font-size: 20px;
        }

        .subtitle {
            color: #68766c;
            margin-bottom: 25px;
        }

        .info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .info p {
            margin: 8px 0;
            color: #526157;
        }

        .info strong { color: #26352b; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th { background: #f0f5ef; }

        .total {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #285c3b;
            margin-top: 20px;
        }

        .back {
            display: inline-block;
            background: #285c3b;
            color: white;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .status {
            display: inline-block;
            background: #fff1ce;
            color: #8a6410;
            padding: 6px 12px;
            border-radius: 20px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d5ded6;
            border-radius: 7px;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 90px;
        }

        .btn-kirim {
            background: #285c3b;
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-kirim:hover { background: #1e472e; }

        .success {
            background: #d9f5df;
            color: #216b35;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error {
            background: #ffe0e0;
            color: #a12626;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .shipment-info p {
            margin: 12px 0;
            color: #526157;
        }

        @media(max-width: 600px) {
            .info { grid-template-columns: 1fr; }

            .card {
                padding: 18px;
                overflow-x: auto;
            }

            table { min-width: 500px; }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>🌱 Tani-Segar | Detail Pesanan</h2>
    </div>

    <div class="container">

        <a href="{{ route('petani.orders.index') }}" class="back">
            ← Kembali ke Pesanan
        </a>

        <h1>Detail Pesanan</h1>
        <p class="subtitle">
            Informasi lengkap pesanan pembeli.
        </p>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="error">
                <strong>Terjadi kesalahan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Informasi Pesanan -->
        <div class="card">
            <h2>Informasi Pesanan</h2>

            <div class="info">
                <p>
                    <strong>Kode Pesanan:</strong><br>
                    {{ $order->kode_pesanan }}
                </p>

                <p>
                    <strong>Tanggal Pesanan:</strong><br>
                    {{ $order->created_at->format('d-m-Y H:i') }}
                </p>

                <p>
                    <strong>Status Pesanan:</strong><br>
                    <span class="status">
                        {{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}
                    </span>
                </p>

                <p>
                    <strong>Metode Pembayaran:</strong><br>
                    {{ strtoupper($order->metode_pembayaran) }}
                </p>
            </div>
        </div>

        <!-- Informasi Pembeli -->
        <div class="card">
            <h2>Informasi Pembeli</h2>

            <p><strong>Nama:</strong> {{ $order->user->name }}</p>
            <p><strong>No. Telepon:</strong> {{ $order->no_telepon }}</p>
            <p><strong>Alamat Pengiriman:</strong> {{ $order->alamat_pengiriman }}</p>

            @if($order->catatan)
                <p><strong>Catatan:</strong> {{ $order->catatan }}</p>
            @endif
        </div>

        <!-- Produk Pesanan -->
        <div class="card">
            <h2>Produk yang Dipesan</h2>

            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->nama_produk }}</td>
                            <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                Total: Rp{{ number_format($order->total_harga, 0, ',', '.') }}
            </div>
        </div>

        <!-- Form Pengiriman -->
        @if($order->status_pesanan === 'diproses')
            <div class="card">
                <h2>🚚 Proses Pengiriman</h2>

                <p class="subtitle">
                    Isi informasi pengiriman setelah pesanan siap dikirim.
                </p>

                <form action="{{ route('petani.orders.ship', $order->id) }}"
                      method="POST">

                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label>Nama Kurir</label>
                        <input type="text"
                               name="nama_kurir"
                               value="{{ old('nama_kurir') }}"
                               placeholder="Contoh: J&T, JNE, atau kurir sendiri"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Nomor Resi</label>
                        <input type="text"
                               name="nomor_resi"
                               value="{{ old('nomor_resi') }}"
                               placeholder="Masukkan nomor resi"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Catatan Pengiriman (Opsional)</label>
                        <textarea name="catatan"
                                  placeholder="Tambahkan catatan pengiriman">{{ old('catatan') }}</textarea>
                    </div>

                    <button type="submit" class="btn-kirim">
                        Kirim Pesanan
                    </button>
                </form>
            </div>
        @endif

        <!-- Informasi Pengiriman -->
      @if($order->shipment && $order->status_pesanan !== 'diproses')
            <div class="card shipment-info">
                <h2>📦 Informasi Pengiriman</h2>

                <p>
                    <strong>Nama Kurir:</strong>
                    {{ $order->shipment->nama_kurir }}
                </p>

                <p>
                    <strong>Nomor Resi:</strong>
                    {{ $order->shipment->nomor_resi }}
                </p>

                <p>
                    <strong>Status Pengiriman:</strong>
                    {{ ucfirst(str_replace('_', ' ', $order->shipment->status_pengiriman)) }}
                </p>

                <p>
                    <strong>Tanggal Dikirim:</strong>
                    {{ $order->shipment->tanggal_kirim
                        ? $order->shipment->tanggal_kirim->format('d-m-Y H:i')
                        : '-' }}
                </p>

                @if($order->shipment->catatan)
                    <p>
                        <strong>Catatan:</strong>
                        {{ $order->shipment->catatan }}
                    </p>
                @endif
            </div>
        @endif

    </div>

</body>
</html>
