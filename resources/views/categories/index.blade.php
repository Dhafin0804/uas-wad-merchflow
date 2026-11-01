
@extends('layouts.app')

@section('title', 'Kategori Produk')
@section('page-heading', 'Kategori Produk')

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

    .btn-disabled {
        background: #cbd5e1;
        color: #64748b;
        cursor: not-allowed;
    }

    .btn:hover:not(:disabled) {
        opacity: 0.85;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 20px;
    }

    .category-card {
        background: white;
        padding: 24px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
    }

    .category-card h2 {
        margin-top: 0;
        font-size: 21px;
    }

    .category-card p {
        color: #666;
        line-height: 1.5;
    }

    .product-count {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 12px;
        border-radius: 8px;
        background: #e8efff;
        color: #244fba;
        font-size: 14px;
        font-weight: bold;
    }

    .category-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .category-actions form {
        margin: 0;
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

    .empty {
        padding: 24px;
        background: white;
        border-radius: 12px;
        text-align: center;
        color: #666;
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

    <!-- Judul halaman -->
    <div class="page-heading">
        <div>
            <h2>Daftar Kategori</h2>
            <p>Kelola dan lihat kategori merchandise.</p>
        </div>

        <a href="{{ route('categories.create') }}" class="btn btn-add">
            + Tambah Kategori
        </a>
    </div>

    <!-- Daftar kategori -->
    @if ($categories->isEmpty())

        <div class="empty">
            <h3>Belum ada kategori</h3>
            <p>Silakan tambahkan data kategori terlebih dahulu.</p>

            <a href="{{ route('categories.create') }}" class="btn btn-edit">
                Tambah Kategori
            </a>
        </div>

    @else

        <div class="category-grid">

            @foreach ($categories as $category)

                <div class="category-card">

                    <h2>{{ $category->name }}</h2>

                    <p>
                        {{ $category->description ?: 'Belum ada deskripsi kategori.' }}
                    </p>

                    <div class="product-count">
                        {{ $category->products_count }} produk
                    </div>

                    <div class="category-actions">

                        <a href="{{ route('categories.edit', $category->id) }}"
                           class="btn btn-edit">
                            Edit
                        </a>

                        @if (auth()->user()->isAdmin())

                            @if ($category->products_count == 0)

                                <form
                                    action="{{ route('categories.destroy', $category->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Apakah kamu yakin ingin menghapus kategori ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-delete">
                                        Hapus
                                    </button>

                                </form>

                            @else

                                <button type="button" class="btn btn-disabled" disabled
                                        title="Kategori masih memiliki produk">
                                    Hapus
                                </button>

                            @endif

                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    @endif

@endsection

