
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Petani - Tani-Segar</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f7f0;
            padding: 30px;
            color: #263b2c;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        h1 {
            color: #287443;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            margin-bottom: 18px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        button {
            padding: 10px 16px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            color: white;
            margin-top: 10px;
        }

        .approve {
            background: #287443;
        }

        .reject {
            background: #dc2626;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 7px;
        }

        .status {
            color: #b7791f;
            font-weight: bold;
        }

        .empty {
            color: #777;
        }
    </style>
</head>

<body>
<div class="container">

    <h1>Verifikasi Calon Petani 🌱</h1>
    <p>Kelola pendaftaran petani Tani-Segar.</p>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @forelse ($farmers as $farmer)
        <div class="card">

            <h3>{{ $farmer->nama_usaha }}</h3>

            <p><strong>Nama:</strong>
                {{ $farmer->user->name }}
            </p>

            <p><strong>Email:</strong>
                {{ $farmer->user->email }}
            </p>

            <p><strong>Telepon:</strong>
                {{ $farmer->no_telepon }}
            </p>

            <p><strong>Alamat:</strong>
                {{ $farmer->alamat }}
            </p>

            <p><strong>Deskripsi:</strong>
                {{ $farmer->deskripsi ?? '-' }}
            </p>

            <p><strong>Status:</strong>
                <span class="status">
                    {{ ucfirst($farmer->status_verifikasi) }}
                </span>
            </p>

            @if ($farmer->status_verifikasi === 'menunggu')

                <form action="{{ route('admin.farmers.approve', $farmer->id) }}"
                    method="POST">
                    @csrf
                    @method('PATCH')

                    <button class="approve" type="submit">
                        Setujui Petani
                    </button>
                </form>

                <form action="{{ route('admin.farmers.reject', $farmer->id) }}"
                    method="POST">
                    @csrf
                    @method('PATCH')

                    <textarea name="alasan_penolakan"
                        placeholder="Masukkan alasan penolakan"
                        required></textarea>

                    <button class="reject" type="submit">
                        Tolak Pendaftaran
                    </button>
                </form>

            @elseif ($farmer->status_verifikasi === 'ditolak')

                <p><strong>Alasan penolakan:</strong>
                    {{ $farmer->alasan_penolakan }}
                </p>

            @endif

        </div>
    @empty
        <div class="card empty">
            Belum ada pendaftaran calon petani.
        </div>
    @endforelse

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="reject" type="submit">Logout</button>
    </form>

</div>
</body>
</html>
