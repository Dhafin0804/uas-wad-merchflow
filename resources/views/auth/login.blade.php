
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MerchFlow</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f1f5f9;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        h1 {
            color: #172554;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 28px;
            font-size: 14px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
            color: #334155;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 13px;
            background: #1d4ed8;
            color: white;
            border: none;
            border-radius: 7px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #1e40af;
        }

        .message {
            padding: 11px;
            margin-bottom: 18px;
            border-radius: 7px;
            font-size: 14px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .register-link {
            text-align: center;
            margin-top: 22px;
            font-size: 14px;
            color: #64748b;
        }

        a {
            color: #1d4ed8;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <h1>MerchFlow</h1>
        <p class="subtitle">Login untuk mengelola pesanan merchandise.</p>

        @if (session('success'))
            <div class="message success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="message error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                required
            >

            <button type="submit">Login</button>
        </form>

    </div>

</body>
</html>
