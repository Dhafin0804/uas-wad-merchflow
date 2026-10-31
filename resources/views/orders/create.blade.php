
@extends('layouts.app')

@section('title', 'Tambah Pesanan')
@section('page-heading', 'Tambah Pesanan')

@push('styles')
<style>
    .form-container {
        max-width: 850px;
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
        margin-bottom: 24px;
    }

    .section-title {
        margin-top: 28px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e5e7eb;
        color: #1e293b;
        font-size: 17px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #334155;
        font-size: 14px;
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
        min-height: 90px;
        resize: vertical;
    }

    .error {
        color: #dc2626;
        font-size: 13px;
        margin-top: 7px;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 14px 18px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-error ul {
        margin-bottom: 0;
        padding-left: 20px;
    }

    .form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 28px;
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

    .btn-secondary {
        background: #e5e7eb;
        color: #374151;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-card">
        <h2>Tambah Pesanan</h2>

        <p class="form-subtitle">
            Masukkan informasi pelanggan dan produk yang dipesan.
        </p>

        @if ($errors->any())
            <div class="alert-error">
                <strong>Periksa kembali data berikut:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <h3 class="section-title">Informasi Pelanggan</h3>

            <div class="form-group">
                <label for="user_id">Pengguna</label>

                <select name="user_id" id="user_id" required>
                    <option value="">Pilih Pengguna</option>

                    @foreach ($users as $user)
                        <option
                            value="{{ $user->id }}"
                            @selected(old('user_id') == $user->id)
                        >
                            {{ $user->name }} - {{ $user->email }}
                        </option>
                    @endforeach
                </select>

                @error('user_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="customer_name">Nama Pelanggan</label>

                <input
                    type="text"
                    name="customer_name"
                    id="customer_name"
                    value="{{ old('customer_name') }}"
                    required
                >

                @error('customer_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="customer_phone">Nomor Telepon</label>

                <input
                    type="text"
                    name="customer_phone"
                    id="customer_phone"
                    value="{{ old('customer_phone') }}"
                    required
                >

                @error('customer_phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="customer_address">Alamat</label>

                <textarea
                    name="customer_address"
                    id="customer_address"
                >{{ old('customer_address') }}</textarea>

                @error('customer_address')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deadline">Deadline Pesanan</label>

                <input
                    type="date"
                    name="deadline"
                    id="deadline"
                    value="{{ old('deadline') }}"
                >

                @error('deadline')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <h3 class="section-title">Detail Produk</h3>

            <div class="form-group">
                <label for="product_id">Pilih Produk</label>

                <select name="product_id" id="product_id" required>
                    <option value="">Pilih Produk</option>

                    @foreach ($products as $product)
                        <option
                            value="{{ $product->id }}"
                            @selected(old('product_id') == $product->id)
                        >
                            {{ $product->name }} -
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                            (Stok: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>

                @error('product_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity">Jumlah Pesanan</label>

                <input
                    type="number"
                    name="quantity"
                    id="quantity"
                    min="1"
                    value="{{ old('quantity', 1) }}"
                    required
                >

                @error('quantity')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">Catatan</label>

                <textarea
                    name="notes"
                    id="notes"
                >{{ old('notes') }}</textarea>

                @error('notes')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Simpan Pesanan
                </button>

                <a href="{{ route('orders.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
