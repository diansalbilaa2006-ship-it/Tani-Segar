
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Tani-Segar</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #f3f7f0;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 15px;
        }

        .container {
            width: 100%;
            max-width: 520px;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.07);
        }

        .brand {
            text-align: center;
            margin-bottom: 25px;
        }

        .brand h1 {
            color: #287443;
            font-size: 30px;
            margin-bottom: 8px;
        }

        .brand p {
            color: #777;
            font-size: 14px;
        }

        h2 {
            color: #263b2c;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #344638;
            font-size: 14px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #dce5dc;
            border-radius: 9px;
            font-size: 14px;
            outline: none;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #32864d;
        }

        textarea {
            resize: vertical;
            min-height: 85px;
        }

        .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .farmer-fields {
            display: none;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
            margin-top: 20px;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #287443;
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #1e5d35;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .footer a {
            color: #287443;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="brand">
        <h1>🌱 Tani-Segar</h1>
        <p>Belanja hasil pertanian langsung dari petani</p>
    </div>

    <h2>Buat Akun Baru</h2>

    @if ($errors->any())
        <div class="success" style="background:#fee2e2;color:#991b1b;">
            <ul style="padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}"
                placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                placeholder="contoh@email.com" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password"
                placeholder="Minimal 8 karakter" required>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                placeholder="Ulangi password" required>
        </div>

        <div class="form-group">
            <label>Daftar Sebagai</label>
            <select name="role" id="role" required>
                <option value="pembeli"
                    {{ old('role', 'pembeli') == 'pembeli' ? 'selected' : '' }}>
                    Pembeli
                </option>

                <option value="calon_petani"
                    {{ old('role') == 'calon_petani' ? 'selected' : '' }}>
                    Calon Petani
                </option>
            </select>
        </div>

        <div class="farmer-fields" id="farmerFields">
            <h3 style="color:#287443;margin-bottom:15px;">
                Data Usaha Pertanian
            </h3>

            <div class="form-group">
                <label>Nama Usaha</label>
                <input type="text" name="nama_usaha"
                    value="{{ old('nama_usaha') }}"
                    placeholder="Nama usaha pertanian">
            </div>

            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" name="no_telepon"
                    value="{{ old('no_telepon') }}"
                    placeholder="08xxxxxxxxxx">
            </div>

            <div class="form-group">
                <label>Alamat Usaha</label>
                <textarea name="alamat"
                    placeholder="Masukkan alamat usaha">{{ old('alamat') }}</textarea>
            </div>

            <div class="form-group">
                <label>Deskripsi Usaha (Opsional)</label>
                <textarea name="deskripsi"
                    placeholder="Ceritakan usaha pertanian kamu">{{ old('deskripsi') }}</textarea>
            </div>
        </div>

        <button type="submit">Daftar Sekarang</button>
    </form>

    <div class="footer">
        Sudah punya akun?
        <a href="{{ route('login') }}">Login di sini</a>
    </div>

</div>

<script>
    const roleSelect = document.getElementById('role');
    const farmerFields = document.getElementById('farmerFields');

    const farmerInputs = farmerFields.querySelectorAll(
        'input[name="nama_usaha"], input[name="no_telepon"], textarea[name="alamat"]'
    );

    function toggleFarmerFields() {
        const isFarmer = roleSelect.value === 'calon_petani';

        farmerFields.style.display = isFarmer ? 'block' : 'none';

        farmerInputs.forEach(input => {
            input.required = isFarmer;
        });
    }

    roleSelect.addEventListener('change', toggleFarmerFields);

    toggleFarmerFields();
</script>

</body>
</html>
