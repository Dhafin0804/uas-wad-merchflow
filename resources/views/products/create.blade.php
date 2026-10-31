
@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('page-heading', 'Tambah Produk')

@push('styles')
<style>
    .form-container {
        max-width: 760px;
    }

    .form-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 28px;
    }

    .form-subtitle {
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 26px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #334155;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font: inherit;
        background: white;
        color: #1e293b;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-group textarea {
        resize: vertical;
    }

    .error {
        color: #dc2626;
        font-size: 13px;
        margin-top: 7px;
    }

    .notice {
        padding: 14px;
        margin-bottom: 20px;
        background: #fff7ed;
        border: 1px solid #fed7aa;
        border-radius: 8px;
        color: #9a3412;
        line-height: 1.6;
    }

    .notice a {
        color: #2563eb;
        font-weight: 600;
    }

    .form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 26px;
    }

    .btn {
        display: inline-block;
        padding: 12px 18px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-primary:disabled {
        background: #94a3b8;
        cursor: not-allowed;
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #374151;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-card">
        <h2>Tambah Produk</h2>

        <p class="form-subtitle">
            Masukkan informasi produk merchandise yang ingin
            ditambahkan ke katalog MerchFlow.
        </p>

        @if ($categories->isEmpty())
            <div class="notice">
                Belum ada kategori. Tambahkan kategori terlebih dahulu
                sebelum membuat produk.

                <a href="{{ route('categories.create') }}">
                    Tambah kategori
                </a>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Kaos Custom Event"
                    required
                >

                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id">Kategori</label>

                <select id="category_id" name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @selected(old('category_id') == $category->id)
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @error('category_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Produk</label>

                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Jelaskan produk merchandise ini"
                >{{ old('description') }}</textarea>

                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Harga (Rp)</label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    value="{{ old('price') }}"
                    min="0"
                    step="0.01"
                    placeholder="Contoh: 75000"
                    required
                >

                @error('price')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock">Stok</label>

                <input
                    type="number"
                    id="stock"
                    name="stock"
                    value="{{ old('stock', 0) }}"
                    min="0"
                    step="1"
                    required
                >

                @error('stock')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_active">Status Produk</label>

                <select id="is_active" name="is_active" required>
                    <option
                        value="1"
                        @selected(old('is_active', '1') == '1')
                    >
                        Aktif
                    </option>

                    <option
                        value="0"
                        @selected(old('is_active') === '0')
                    >
                        Tidak Aktif
                    </option>
                </select>

                @error('is_active')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button
                    type="submit"
                    class="btn btn-primary"
                    @disabled($categories->isEmpty())
                >
                    Simpan Produk
                </button>

                <a
                    class="btn btn-secondary"
                    href="{{ route('products.index') }}"
                >
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

