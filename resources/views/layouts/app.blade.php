
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'MerchFlow') | MerchFlow</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6fa;
            color: #1e293b;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 245px;
            min-height: 100vh;
            background: #172554;
            color: white;
            padding: 28px 18px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }

        .brand {
            font-size: 23px;
            font-weight: bold;
            margin: 0 12px 42px;
        }

        .brand span {
            color: #60a5fa;
        }

        .menu-label {
            color: #94a3b8;
            font-size: 11px;
            margin: 25px 12px 12px;
            letter-spacing: 1px;
        }

        .menu a {
            display: block;
            padding: 13px 14px;
            margin-bottom: 7px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.2s;
        }

        .menu a:hover,
        .menu a.active {
            background: #2563eb;
            color: white;
        }

        .logout-form {
            margin-top: auto;
            padding-top: 25px;
        }

        .logout-button {
            width: 100%;
            padding: 13px 14px;
            border: none;
            border-radius: 8px;
            background: #fee2e2;
            color: #b91c1c;
            text-align: left;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .logout-button:hover {
            background: #fecaca;
        }

        /* MAIN CONTENT */
        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            background: white;
            padding: 22px 35px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar h2 {
            font-size: 20px;
        }

        .admin {
            font-size: 13px;
            color: #64748b;
        }

        .content {
            padding: 32px 35px;
        }

        /* RESPONSIVE */
        @media (max-width: 700px) {
            .layout {
                display: block;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
                padding: 18px;
            }

            .brand {
                margin: 0 0 15px;
            }

            .menu {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }

            .menu-label {
                display: none;
            }

            .menu a {
                margin: 0;
            }

            .logout-form {
                margin-top: 15px;
                padding-top: 0;
            }

            .topbar {
                padding: 18px;
            }

            .content {
                padding: 20px 16px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="brand">
            Merch<span>Flow.</span>
        </div>

        <div class="menu-label">MENU UTAMA</div>

        <nav class="menu">

            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                ▦ &nbsp; Dashboard
            </a>

            <a href="{{ route('products.index') }}"
               class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                ◈ &nbsp; Produk
            </a>

            <a href="{{ route('categories.index') }}"
               class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                ▤ &nbsp; Kategori
            </a>

            <a href="{{ route('orders.index') }}"
               class="{{ request()->routeIs('orders.index', 'orders.show', 'orders.edit') ? 'active' : '' }}">
                ▣ &nbsp; Pesanan
            </a>

        </nav>

        <div class="menu-label">SISTEM</div>

        <nav class="menu">
            <a href="{{ route('orders.create') }}"
               class="{{ request()->routeIs('orders.create') ? 'active' : '' }}">
                + &nbsp; Buat Pesanan
            </a>
        </nav>

        <!-- LOGOUT -->
        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf

            <button type="submit" class="logout-button">
                ↪ &nbsp; Logout
            </button>
        </form>

    </aside>

    <!-- AREA KONTEN -->
    <main class="main">

        <header class="topbar">
            <h2>@yield('page-heading', 'Dashboard')</h2>

            <div class="admin">
                {{ Auth::user()->name }}
            </div>
        </header>

        <section class="content">
            @yield('content')
        </section>

    </main>

</div>

@stack('scripts')

</body>
</html>
