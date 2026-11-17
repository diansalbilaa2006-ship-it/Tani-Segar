
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Tani-Segar</title>

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
        }

        .navbar a {
            color: white;
            text-decoration: none;
        }

        .container {
            max-width: 950px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 23px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,.05);
        }

        h2 { margin-top: 0; font-size: 19px; }

        .muted { color: #788278; font-size: 13px; }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin: 13px 0;
        }

        .product {
            border-bottom: 1px solid #eee;
            padding: 14px 0;
        }

        .total {
            color: #244d35;
            font-weight: bold;
            font-size: 18px;
        }

        .status {
            display: inline-block;
            background: #fff2cf;
            color: #916400;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            background: #244d35;
            color: white;
            padding: 11px 18px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-success {
            background: #287a43;
        }

        .alert-success {
            background: #dff5e5;
            color: #246b38;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .alert-error {
            background: #ffe3e3;
            color: #a32626;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .shipment p {
            margin: 13px 0;
        }

        @media(max-width:600px) {
            .row { flex-direction: column; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <strong>🌱 Tani-Segar</strong>
    <a href="{{ route('pembeli.orders.index') }}" style="float:right;">
        Kembali ke Pesanan
    </a>
</nav>

<div class="container">

    <h1>Detail Pesanan</h1>
    <p class="muted">Informasi lengkap transaksi kamu.</p>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Informasi Pesanan -->
    <div class="card">
        <h2>Informasi Pesanan</h2>

        <div class="row">
            <span>Kode Pesanan</span>
            <strong>{{ $order->kode_pesanan }}</strong>
        </div>

        <div class="row">
            <span>Tanggal Pesanan</span>
            <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong>
        </div>

        <div class="row">
            <span>Petani</span>
            <strong>{{ $order->farmer->nama_usaha ?? 'Petani' }}</strong>
        </div>

        <div class="row">
            <span>Status Pesanan</span>
            <span class="status">
                {{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}
            </span>
        </div>
    </div>

    <!-- Produk -->
    <div class="card">
        <h2>Produk yang Dipesan</h2>

        @foreach($order->items as $item)
            <div class="product">
                <strong>{{ $item->nama_produk }}</strong>

                <div class="row">
                    <span class="muted">
                        {{ $item->jumlah }} ×
                        Rp{{ number_format($item->harga, 0, ',', '.') }}
                    </span>

                    <strong>
                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                    </strong>
                </div>
            </div>
        @endforeach

        <div class="row">
            <span>Subtotal</span>
            <strong>
                Rp{{ number_format($order->subtotal, 0, ',', '.') }}
            </strong>
        </div>

        <div class="row">
            <span>Ongkos Kirim</span>
            <strong>
                Rp{{ number_format($order->ongkir, 0, ',', '.') }}
            </strong>
        </div>

        <div class="row total">
            <span>Total Pembayaran</span>
            <span>
                Rp{{ number_format($order->total_harga, 0, ',', '.') }}
            </span>
        </div>
    </div>

    <!-- Informasi Pembayaran -->
    <div class="card">
        <h2>Informasi Pembayaran</h2>

        <div class="row">
            <span>Metode Pembayaran</span>
            <strong>{{ strtoupper($order->payment->metode_pembayaran ?? '-') }}</strong>
        </div>

        <div class="row">
            <span>Status Pembayaran</span>
            <strong>
                {{ ucfirst(str_replace('_', ' ', $order->payment->status_pembayaran ?? 'menunggu')) }}
            </strong>
        </div>

        @if($order->payment && $order->payment->metode_pembayaran === 'transfer')

            @if($order->payment->bukti_pembayaran)
                <div style="margin:18px 0;">
                    <strong>Bukti Pembayaran:</strong><br><br>

                    <img
                        src="{{ asset('storage/' . $order->payment->bukti_pembayaran) }}"
                        alt="Bukti Pembayaran"
                        style="max-width:250px;width:100%;border-radius:8px;border:1px solid #ddd;"
                    >
                </div>
            @endif

            @if(in_array($order->payment->status_pembayaran, ['menunggu', 'ditolak']))
                <div style="margin-top:20px;">
                    <h3>Upload Bukti Pembayaran</h3>

                    @if($order->payment->status_pembayaran === 'ditolak')
                        <p style="color:#b42318;">
                            Bukti pembayaran sebelumnya ditolak. Silakan unggah ulang.
                        </p>
                    @else
                        <p class="muted">
                            Unggah foto bukti transfer. Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                        </p>
                    @endif

                    <form
                        action="{{ route('pembeli.orders.payment-proof', $order->id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        <input
                            type="file"
                            name="bukti_pembayaran"
                            accept="image/jpeg,image/png,image/webp"
                            required
                            style="display:block;margin:15px 0;"
                        >

                        <button type="submit" class="btn">
                            Upload Bukti Pembayaran
                        </button>
                    </form>
                </div>

            @elseif($order->payment->status_pembayaran === 'menunggu_verifikasi')
                <p style="color:#916400;margin-top:15px;">
                    Bukti pembayaran sudah diunggah dan sedang menunggu verifikasi admin.
                </p>

            @elseif($order->payment->status_pembayaran === 'berhasil')
                <p style="color:#246b38;margin-top:15px;">
                    Pembayaran berhasil diverifikasi. Terima kasih!
                </p>
            @endif

        @elseif($order->payment && $order->payment->metode_pembayaran === 'cod')
            <p class="muted" style="margin-top:15px;">
                Pembayaran dilakukan secara tunai saat pesanan diterima.
            </p>
        @endif
    </div>

    <!-- Informasi Pengiriman -->
    @if($order->shipment && $order->shipment->nomor_resi)
        <div class="card shipment">
            <h2>Informasi Pengiriman</h2>

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

            @if($order->shipment->tanggal_diterima)
                <p>
                    <strong>Tanggal Diterima:</strong>
                    {{ $order->shipment->tanggal_diterima->format('d-m-Y H:i') }}
                </p>
            @endif

            @if($order->shipment->catatan)
                <p>
                    <strong>Catatan Pengiriman:</strong>
                    {{ $order->shipment->catatan }}
                </p>
            @endif

            @if($order->status_pesanan === 'dikirim')
                <hr style="border:0;border-top:1px solid #eee;margin:20px 0;">

                <h3>Apakah Pesanan Sudah Diterima?</h3>
                <p class="muted">
                    Pastikan barang sudah kamu terima sebelum melakukan konfirmasi.
                </p>

                <form
                    action="{{ route('pembeli.orders.confirm-received', $order->id) }}"
                    method="POST"
                    onsubmit="return confirm('Apakah kamu yakin pesanan sudah diterima?')"
                >
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="btn btn-success">
                        Pesanan Diterima
                    </button>
                </form>

            @elseif($order->status_pesanan === 'selesai')
                <p style="color:#246b38;font-weight:bold;">
                    Pesanan sudah berhasil diterima. Terima kasih telah berbelanja di Tani-Segar!
                </p>
            @endif
        </div>
    @endif

    <a href="{{ route('pembeli.orders.index') }}" class="btn">
        Kembali ke Riwayat Pesanan
    </a>

</div>

</body>
</html>
