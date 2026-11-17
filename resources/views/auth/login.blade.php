
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tani-Segar</title>

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
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 430px;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.07);
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
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
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #344638;
            font-size: 14px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #dce5dc;
            border-radius: 9px;
            font-size: 14px;
            outline: none;
        }

        input:focus {
            border-color: #32864d;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            font-size: 13px;
            color: #666;
        }

        .remember input {
            width: auto;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 13px;
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
        }

        button:hover {
            background: #1e5d35;
        }

        .footer {
            text-align: center;
            margin-top: 22px;
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
        <p>Selamat datang kembali!</p>
    </div>

    <h2>Login Akun</h2>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('login.process') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email"
                required
            >
        </div>

        <div class="form-group">
            <label>Password</label>
            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >
        </div>

        <div class="remember">
            <input type="checkbox" name="remember" value="1">
            <label style="margin:0;font-weight:normal;">
                Ingat saya
            </label>
        </div>

        <button type="submit">Login Sekarang</button>
    </form>

    <div class="footer">
        Belum punya akun?
        <a href="{{ route('register') }}">Daftar sekarang</a>
    </div>

</div>

</body>
</html>
