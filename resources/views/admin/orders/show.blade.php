
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Tani-Segar</title>

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
        }

        .container {
            max-width: 1000px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #285c3b;
            text-decoration: none;
            font-weight: bold;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.04);
        }

        h1 {
            margin-bottom: 8px;
        }

        h2 {
            font-size: 19px;
            margin-bottom: 18px;
            color: #285c3b;
        }

        .subtitle {
            color: #68766c;
            margin-bottom: 25px;
        }

        .info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .info-item p {
            color: #68766c;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .info-item strong {
            overflow-wrap: anywhere;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        th {
            background: #eef4ed;
            color: #285c3b;
        }

        .total {
            margin-top: 18px;
            text-align: right;
            font-size: 19px;
            font-weight: bold;
            color: #285c3b;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #eef4ed;
            font-size: 13px;
        }

        .proof {
            display: inline-block;
            margin-top: 10px;
            color: #285c3b;
            font-weight: bold;
        }

        @media(max-width: 600px) {
            .info {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 18px;
            }

            .table-wrapper {
                overflow-x: auto;
            }

            table {
                min-width: 550px;
            }
        }
    </style>
</head>

<body>

<div class="navbar">
    <h2>🌱 Tani-Segar | Admin</h2>
</div>

<div class="container">

    <a href="{{ route('admin.orders.index') }}" class="back">
        ← Kembali ke Daftar Pesanan
    </a>

    <h1>Detail Pesanan</h1>
    <p class="subtitle">{{ $order->kode_pesanan }}</p>

    <!-- Informasi Pesanan -->
    <div class="card">
        <h2>Informasi Pesanan</h2>

        <div class="info">
            <div class="info-item">
                <p>Kode Pesanan</p>
                <strong>{{ $order->kode_pesanan }}</strong>
            </div>

            <div class="info-item">
                <p>Tanggal Pesanan</p>
                <strong>{{ $order->created_at->format('d-m-Y H:i') }}</strong>
            </div>

            <div class="info-item">
                <p>Status Pesanan</p>
                <span class="status">
                    {{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}
                </span>
            </div>

            <div class="info-item">
                <p>Metode Pembayaran</p>
                <strong>{{ strtoupper($order->metode_pembayaran) }}</strong>
            </div>
        </div>
    </div>

    <!-- Informasi Pembeli dan Petani -->
    <div class="card">
        <h2>Informasi Pembeli dan Petani</h2>

        <div class="info">
            <div class="info-item">
                <p>Nama Pembeli</p>
                <strong>{{ $order->user->name ?? '-' }}</strong>
            </div>

            <div class="info-item">
                <p>Nomor Telepon</p>
                <strong>{{ $order->no_telepon ?? '-' }}</strong>
            </div>

            <div class="info-item">
                <p>Nama Petani</p>
                <strong>{{ $order->farmer->user->name ?? '-' }}</strong>
            </div>

            <div class="info-item">
                <p>Alamat Pengiriman</p>
                <strong>{{ $order->alamat_pengiriman }}</strong>
            </div>
        </div>
    </div>

    <!-- Produk Pesanan -->
    <div class="card">
        <h2>Produk yang Dipesan</h2>

        <div class="table-wrapper">
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
        </div>

        <div class="total">
            Subtotal: Rp{{ number_format($order->subtotal, 0, ',', '.') }}
            <br>
            Ongkir: Rp{{ number_format($order->ongkir, 0, ',', '.') }}
            <br>
            Total: Rp{{ number_format($order->total_harga, 0, ',', '.') }}
        </div>
    </div>

    <!-- Informasi Pembayaran -->
    <div class="card">
        <h2>Informasi Pembayaran</h2>

        <div class="info">
            <div class="info-item">
                <p>Metode Pembayaran</p>
                <strong>{{ strtoupper($order->payment->metode_pembayaran ?? $order->metode_pembayaran) }}</strong>
            </div>

            <div class="info-item">
                <p>Status Pembayaran</p>
                <strong>
                    {{ ucfirst(str_replace('_', ' ', $order->payment->status_pembayaran ?? 'belum ada')) }}
                </strong>
            </div>

            <div class="info-item">
                <p>Jumlah Pembayaran</p>
                <strong>
                    Rp{{ number_format($order->payment->jumlah_bayar ?? 0, 0, ',', '.') }}
                </strong>
            </div>

            <div class="info-item">
                <p>Tanggal Pembayaran</p>
                <strong>
                    {{ $order->payment?->tanggal_bayar?->format('d-m-Y H:i') ?? '-' }}
                </strong>
            </div>
        </div>

        @if($order->payment && $order->payment->bukti_pembayaran)
            <a
                href="{{ asset('storage/' . $order->payment->bukti_pembayaran) }}"
                target="_blank"
                class="proof"
            >
                Lihat Bukti Pembayaran
            </a>
        @endif

        @if($order->payment && $order->payment->catatan_admin)
            <p style="margin-top: 15px;">
                Catatan Admin: {{ $order->payment->catatan_admin }}
            </p>
        @endif
    </div>

    <!-- Informasi Pengiriman -->
    <div class="card">
        <h2>Informasi Pengiriman</h2>

        @if($order->shipment)
            <div class="info">
                <div class="info-item">
                    <p>Kurir</p>
                    <strong>{{ $order->shipment->nama_kurir ?? '-' }}</strong>
                </div>

                <div class="info-item">
                    <p>Nomor Resi</p>
                    <strong>{{ $order->shipment->nomor_resi ?? '-' }}</strong>
                </div>

                <div class="info-item">
                    <p>Status Pengiriman</p>
                    <strong>
                        {{ ucfirst($order->shipment->status_pengiriman ?? '-') }}
                    </strong>
                </div>

                <div class="info-item">
                    <p>Tanggal Dikirim</p>
                    <strong>
                        {{ $order->shipment->tanggal_kirim?->format('d-m-Y H:i') ?? '-' }}
                    </strong>
                </div>

                <div class="info-item">
                    <p>Tanggal Diterima</p>
                    <strong>
                        {{ $order->shipment->tanggal_diterima?->format('d-m-Y H:i') ?? '-' }}
                    </strong>
                </div>
            </div>
        @else
            <p>Belum ada informasi pengiriman.</p>
        @endif
    </div>

</div>

</body>
</html>
