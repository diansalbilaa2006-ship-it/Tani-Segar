
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Masuk - Tani-Segar</title>

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
            max-width: 1150px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,.05);
            overflow-x: auto;
        }

        h1 {
            margin-bottom: 8px;
        }

        .subtitle {
            color: #68766c;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 750px;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f0f5ef;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #fff1ce;
            color: #8a6410;
            font-size: 12px;
        }

        .btn {
            display: inline-block;
            background: #285c3b;
            color: white;
            text-decoration: none;
            padding: 9px 14px;
            border-radius: 6px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #68766c;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>🌱 Tani-Segar | Pesanan Petani</h2>
    </div>

    <div class="container">

        <h1>Pesanan Masuk</h1>
        <p class="subtitle">
            Daftar pesanan pembeli untuk produk di toko kamu.
        </p>

        <div class="card">

            <table>
                <thead>
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Pembeli</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->kode_pesanan }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                            <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="status">
                                    {{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('petani.orders.show', $order->id) }}" class="btn">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada pesanan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 20px;">
                {{ $orders->links() }}
            </div>

        </div>

    </div>

</body>
</html>
