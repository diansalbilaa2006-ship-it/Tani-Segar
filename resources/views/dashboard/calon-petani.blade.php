
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Calon Petani | Tani-Segar</title>

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
            max-width: 900px;
            margin: 45px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px #0000000a;
        }

        h1 {
            color: #245c3b;
        }

        .status {
            margin: 20px 0;
            padding: 18px;
            border-radius: 8px;
            background: #fff4d6;
            color: #856404;
            font-weight: bold;
        }

        .status.diterima {
            background: #dff5e5;
            color: #246b3b;
        }

        .status.ditolak {
            background: #fde2e2;
            color: #a52828;
        }

        .reason {
            padding: 15px;
            background: #fff1f1;
            border-radius: 8px;
            margin-top: 15px;
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
    <h2>🌱 Tani-Segar | Calon Petani</h2>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout">Logout</button>
    </form>
</header>

<div class="container">
    <div class="card">

        <h1>Selamat Datang, {{ $user->name }}! 👋</h1>

        <p>
            Terima kasih telah mendaftar sebagai petani di Tani-Segar.
            Silakan pantau status pendaftaran akun kamu di bawah ini.
        </p>

        @if (($stats['status_verifikasi'] ?? '') === 'menunggu')
            <div class="status">
                ⏳ Status Pendaftaran: Menunggu Verifikasi
            </div>

            <p>
                Pendaftaran kamu sedang diperiksa oleh admin.
                Silakan tunggu sampai proses verifikasi selesai.
            </p>

        @elseif (($stats['status_verifikasi'] ?? '') === 'diterima')
            <div class="status diterima">
                ✅ Status Pendaftaran: Diterima
            </div>

            <p>
                Selamat! Pendaftaran kamu telah disetujui.
                Silakan login kembali untuk mengakses akun petani.
            </p>

        @elseif (($stats['status_verifikasi'] ?? '') === 'ditolak')
            <div class="status ditolak">
                ❌ Status Pendaftaran: Ditolak
            </div>

            @if (!empty($stats['alasan_penolakan']))
                <div class="reason">
                    <strong>Alasan Penolakan:</strong>
                    <p>{{ $stats['alasan_penolakan'] }}</p>
                </div>
            @endif

            <p>
                Silakan hubungi admin jika membutuhkan informasi lebih lanjut.
            </p>

        @else
            <div class="status">
                Informasi pendaftaran belum tersedia.
            </div>
        @endif

    </div>
</div>

<footer>
    © {{ date('Y') }} Tani-Segar. Belanja Segar, Langsung dari Petani.
</footer>

</body>
</html>
