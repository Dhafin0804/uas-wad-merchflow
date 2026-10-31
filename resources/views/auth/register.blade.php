
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | MerchFlow</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .register-box {
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        }

        h1 {
            color: #172554;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 25px;
            font-size: 14px;
        }

        label {
            display: block;
            margin: 15px 0 7px;
            font-size: 14px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            outline: none;
        }

        input:focus {
            border-color: #2563eb;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 23px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #1d4ed8;
        }

        .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 10px;
            border-radius: 7px;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #64748b;
        }

        a {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="register-box">

        <h1>MerchFlow.</h1>
        <p class="subtitle">Buat akun untuk mulai menggunakan MerchFlow.</p>

        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <label>Nama Lengkap</label>
            <input type="text" name="name"
                value="{{ old('name') }}"
                placeholder="Masukkan nama lengkap">
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Email</label>
            <input type="email" name="email"
                value="{{ old('email') }}"
                placeholder="nama@email.com">
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Password</label>
            <input type="password" name="password"
                placeholder="Minimal 8 karakter">
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                placeholder="Ulangi password">

            <button type="submit">Daftar Sekarang</button>
        </form>

        <div class="login-link">
            Sudah punya akun?
            <span>Fitur login akan segera tersedia.</span>
        </div>

    </div>
</body>
</html>
