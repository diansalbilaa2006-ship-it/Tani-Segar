
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pembayaran - Tani-Segar</title>

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

        .container {
            max-width: 1200px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 950px;
        }

        th, td {
            padding: 13px;
            text-align: left;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        th {
            background: #edf4ee;
        }

        .status {
            display: inline-block;
            background: #fff2cf;
            color: #916400;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            white-space: nowrap;
        }

        .btn {
            display: inline-block;
            background: #244d35;
            color: white;
            padding: 9px 13px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-approve {
            background: #278344;
            color: white;
            padding: 9px 13px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-reject {
            background: #c0392b;
            color: white;
            padding: 9px 13px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        textarea {
            width: 100%;
            min-height: 65px;
            padding: 9px;
            border: 1px solid #ddd;
            border-radius: 6px;
            resize: vertical;
            font-family: Arial, sans-serif;
        }

        .alert {
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 15px;
        }

        .success {
            background: #dff5e5;
            color: #246b38;
        }

        .error {
            background: #ffe3e3;
            color: #a32626;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #788278;
        }

        @media(max-width:600px) {
            .container { padding: 0 12px; }
            .card { padding: 14px; }
        }
    </style>
</head>

<body>

<div class="navbar">
    <strong>🌱 Tani-Segar | Admin</strong>
</div>

<div class="container">

    <h1>Verifikasi Pembayaran</h1>
    <p>Daftar pembayaran transfer yang menunggu pemeriksaan admin.</p>

    <div class="card">

        {{-- Notifikasi berhasil --}}
        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Notifikasi gagal --}}
        @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif

        {{-- Notifikasi validasi --}}
        @if($errors->any())
            <div class="alert error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if($payments->count() > 0)

            <table>
                <thead>
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Pembeli</th>
                        <th>Petani</th>
                        <th>Total Pembayaran</th>
                        <th>Tanggal Upload</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($payments as $payment)

                        <tr>
                            <td>
                                {{ $payment->order->kode_pesanan }}
                            </td>

                            <td>
                                {{ $payment->order->user->name ?? '-' }}
                            </td>

                            <td>
                                {{ $payment->order->farmer->nama_usaha ?? '-' }}
                            </td>

                            <td>
                                Rp{{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $payment->tanggal_bayar ? $payment->tanggal_bayar->format('d-m-Y H:i') : '-' }}
                            </td>

                            <td>
                                <span class="status">
                                    Menunggu Verifikasi
                                </span>
                            </td>

                            <td>
                                @if($payment->bukti_pembayaran)
                                    <a
                                        href="{{ asset('storage/' . $payment->bukti_pembayaran) }}"
                                        target="_blank"
                                        class="btn"
                                    >
                                        Lihat Bukti
                                    </a>
                                @else
                                    -
                                @endif
                            </td>

                            <td style="min-width:190px;">

                                {{-- Form Setujui --}}
                                <form
                                    action="{{ route('admin.payments.approve', $payment->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menyetujui pembayaran ini?')"
                                    style="margin-bottom:12px;"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn-approve">
                                        Setujui
                                    </button>
                                </form>

                                {{-- Form Tolak --}}
                                <form
                                    action="{{ route('admin.payments.reject', $payment->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menolak pembayaran ini?')"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <textarea
                                        name="catatan_admin"
                                        placeholder="Alasan penolakan..."
                                        maxlength="500"
                                        required
                                    ></textarea>

                                    <button
                                        type="submit"
                                        class="btn-reject"
                                        style="margin-top:7px;"
                                    >
                                        Tolak
                                    </button>
                                </form>

                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>

            <div style="margin-top:20px;">
                {{ $payments->links() }}
            </div>

        @else

            <div class="empty">
                <h3>Belum Ada Pembayaran</h3>
                <p>Tidak ada pembayaran yang menunggu verifikasi saat ini.</p>
            </div>

        @endif

    </div>

</div>

</body>
</html>
