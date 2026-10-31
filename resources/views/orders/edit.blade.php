
@extends('layouts.app')

@section('title', 'Edit Pesanan')
@section('page-heading', 'Edit Pesanan')

@push('styles')
<style>
    .form-container {
        max-width: 850px;
        background: white;
        padding: 28px;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 7px;
        color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 11px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        font-family: Arial, sans-serif;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }

    .section-title {
        margin-top: 28px;
        margin-bottom: 18px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
        font-size: 17px;
    }

    .product-info {
        padding: 14px;
        background: #f8fafc;
        border: 1px solid #eee;
        border-radius: 6px;
        margin-bottom: 12px;
    }

    .product-info strong {
        color: #172554;
    }

    .error {
        padding: 12px 16px;
        margin-bottom: 18px;
        background: #fef2f2;
        color: #dc2626;
        border-radius: 6px;
        font-size: 13px;
    }

    .buttons {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .btn {
        display: inline-block;
        padding: 11px 18px;
        border: none;
        border-radius: 6px;
        text-decoration: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #333;
    }
</style>
@endpush

@section('content')

<div class="form-container">

    <h2>Edit Pesanan #{{ $order->id }}</h2>
    <p>Perbarui informasi pesanan pelanggan.</p>

    @if ($errors->any())
        <div class="error">
            <strong>Periksa kembali data berikut:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <h3 class="section-title">Informasi Pelanggan</h3>

        <div class="form-group">
            <label>Nama Pelanggan</label>
            <input
                type="text"
                name="customer_name"
                value="{{ old('customer_name', $order->customer_name) }}"
                required
            >
        </div>

        <div class="form-group">
            <label>Nomor Telepon</label>
            <input
                type="text"
                name="customer_phone"
                value="{{ old('customer_phone', $order->customer_phone) }}"
                required
            >
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="customer_address">{{ old('customer_address', $order->customer_address) }}</textarea>
        </div>

        <div class="form-group">
            <label>Deadline Pesanan</label>
            <input
                type="date"
                name="deadline"
                value="{{ old('deadline', $order->deadline ? \Carbon\Carbon::parse($order->deadline)->format('Y-m-d') : '') }}"
            >
        </div>

        <h3 class="section-title">Status Pesanan</h3>

        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                @foreach (['baru', 'dikonfirmasi', 'diproses', 'selesai', 'dibatalkan'] as $status)
                    <option
                        value="{{ $status }}"
                        {{ old('status', $order->status) == $status ? 'selected' : '' }}
                    >
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <h3 class="section-title">Detail Produk</h3>

        @foreach ($order->orderItems as $item)
            <div class="product-info">
                <strong>{{ $item->product->name }}</strong>
                <br>
                Harga: Rp{{ number_format($item->price, 0, ',', '.') }}
                <br>
                Jumlah: {{ $item->quantity }}
            </div>
        @endforeach

        <div class="form-group">
            <label>Catatan</label>
            <textarea name="notes">{{ old('notes', $order->notes) }}</textarea>
        </div>

        <div class="buttons">
            <button type="submit" class="btn btn-primary">
                Simpan Perubahan
            </button>

            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>

</div>

@endsection

