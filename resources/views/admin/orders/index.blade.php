
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan - Tani-Segar</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
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

        .navbar a {
            color: white;
            text-decoration: none;
        }

        .container {
            max-width: 1200px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header p {
            color: #68766c;
            margin-top: 8px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #285c3b;
            text-decoration: none;
            font-weight: bold;
        }

        .filter {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        input, select {
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        input {
            flex: 1;
            min-width: 200px;
        }

        button, .reset {
            padding: 11px 18px;
            border: none;
            border-radius: 6px;
            background: #285c3b;
            color: white;
            cursor: pointer;
            text-decoration: none;
        }

        .reset {
            background: #68766c;
        }

        .table-wrapper {
            background: white;
            padding: 20px;
            border-radius: 10px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        th {
            background: #eef4ed;
            color: #285c3b;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #eee;
            font-size: 12px;
        }

        .detail {
            color: #285c3b;
            font-weight: bold;
            text-decoration: none;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #68766c;
        }

        .pagination {
            margin-top: 20px;
        }

        @media(max-width: 600px) {
            .navbar {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<div class="navbar">
    <h2>🌱 Tani-Segar | Admin</h2>
    <a href="{{ route('dashboard') }}">Dashboard</a>
</div>

<div class="container">

    <a href="{{ route('dashboard') }}" class="back">← Kembali ke Dashboard</a>

    <div class="header">
        <h1>Kelola Pesanan</h1>
        <p>Pantau seluruh pesanan pembeli dari semua petani Tani-Segar.</p>
    </div>

    <form action="{{ route('admin.orders.index') }}" method="GET" class="filter">

        <input
            type="text"
            name="search"
            placeholder="Cari kode pesanan atau nama pembeli..."
            value="{{ request('search') }}"
        >

        <select name="status">
            <option value="">Semua Status</option>
            <option value="menunggu_pembayaran" @selected(request('status') == 'menunggu_pembayaran')>Menunggu Pembayaran</option>
            <option value="diproses" @selected(request('status') == 'diproses')>Diproses</option>
            <option value="dikirim" @selected(request('status') == 'dikirim')>Dikirim</option>
            <option value="selesai" @selected(request('status') == 'selesai')>Selesai</option>
        </select>

        <button type="submit">Cari</button>
        <a href="{{ route('admin.orders.index') }}" class="reset">Reset</a>

    </form>

    <div class="table-wrapper">

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Pesanan</th>
                    <th>Pembeli</th>
                    <th>Petani</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status Pesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $orders->firstItem() + $loop->index }}</td>

                        <td>{{ $order->kode_pesanan }}</td>

                        <td>{{ $order->user->name ?? '-' }}</td>

                        <td>{{ $order->farmer->user->name ?? '-' }}</td>

                        <td>{{ $order->created_at->format('d-m-Y') }}</td>

                        <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>

                        <td>
                            <span class="badge">
                                {{ strtoupper($order->metode_pembayaran) }}
                            </span>
                            <br><br>
                            {{ ucfirst(str_replace('_', ' ', $order->payment->status_pembayaran ?? 'belum ada')) }}
                        </td>

                        <td>
                            <span class="badge">
                                {{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="detail">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="empty">
                            Belum ada pesanan ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $orders->links() }}
        </div>

    </div>

</div>

</body>
</html>
