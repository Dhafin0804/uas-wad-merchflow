
@extends('layouts.app')

@section('title', 'Daftar Produk')
@section('page-heading', 'Daftar Produk')

@push('styles')
<style>
    .page-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .page-heading h2 {
        margin-bottom: 6px;
    }

    .page-heading p {
        color: #64748b;
        margin-top: 0;
    }

    .heading-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .total-product {
        color: #475569;
        font-size: 14px;
    }

    .btn {
        display: inline-block;
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        border: none;
        cursor: pointer;
    }

    .btn-add,
    .btn-edit {
        background: #2563eb;
        color: white;
    }

    .btn-delete {
        background: #dc2626;
        color: white;
    }

    .btn:hover {
        opacity: 0.85;
    }

    .alert-success {
        padding: 14px 18px;
        margin-bottom: 22px;
        background: #dcfce7;
        color: #166534;
        border-radius: 8px;
    }

    .alert-error {
        padding: 14px 18px;
        margin-bottom: 22px;
        background: #fee2e2;
        color: #991b1b;
        border-radius: 8px;
    }

    .alert-error ul {
        margin: 8px 0 0 20px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }

    .category {
        display: inline-block;
        background: #dbeafe;
        color: #1d4ed8;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .product-card h3 {
        margin-bottom: 8px;
    }

    .description {
        min-height: 42px;
        color: #64748b;
        line-height: 1.5;
        font-size: 14px;
    }

    .price {
        color: #1d4ed8;
        font-size: 21px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .stock {
        color: #475569;
        font-size: 14px;
    }

    .status {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 12px;
        margin-bottom: 12px;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .product-actions {
        display: flex;
        gap: 10px;
        margin-top: 18px;
        flex-wrap: wrap;
    }

    .product-actions form {
        margin: 0;
    }

    .empty {
        background: white;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
        color: #64748b;
    }

    @media (max-width: 600px) {
        .page-heading {
            align-items: flex-start;
        }

        .heading-actions {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>
@endpush

@section('content')

    <!-- Notifikasi berhasil -->
    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Notifikasi error -->
    @if (session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Judul halaman dan tombol tambah -->
    <div class="page-heading">

        <div>
            <h2>Daftar Produk</h2>
            <p>Kelola dan lihat katalog produk merchandise.</p>
        </div>

        <div class="heading-actions">

            <strong class="total-product">
                Total produk: {{ $products->count() }}
            </strong>

            <a href="{{ route('products.create') }}" class="btn btn-add">
                + Tambah Produk
            </a>

        </div>

    </div>

    <!-- Daftar produk -->
    @if ($products->isEmpty())

        <div class="empty">
            <h3>Belum ada produk</h3>
            <p>Data produk belum tersedia di database.</p>

            <a href="{{ route('products.create') }}" class="btn btn-add">
                Tambah Produk Pertama
            </a>
        </div>

    @else

        <div class="product-grid">

            @foreach ($products as $product)

                <article class="product-card">

                    <span class="category">
                        {{ $product->category?->name ?? 'Tanpa kategori' }}
                    </span>

                    <h3>{{ $product->name }}</h3>

                    <p class="description">
                        {{ $product->description ?? 'Tidak ada deskripsi produk.' }}
                    </p>

                    <p class="price">
                        Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                    </p>

                    <p class="stock">
                        Stok tersedia: {{ $product->stock }}
                    </p>

                    <!-- Status produk -->
                    @if ($product->is_active)
                        <span class="status status-active">
                            Aktif
                        </span>
                    @else
                        <span class="status status-inactive">
                            Tidak Aktif
                        </span>
                    @endif

                    <!-- Tombol edit dan hapus -->
                    <div class="product-actions">

                        <a href="{{ route('products.edit', $product->id) }}"
                           class="btn btn-edit">
                            Edit
                        </a>

                        <form
                            action="{{ route('products.destroy', $product->id) }}"
                            method="POST"
                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus produk ini?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-delete">
                                Hapus
                            </button>

                        </form>

                    </div>

                </article>

            @endforeach

        </div>

    @endif

@endsection

