
@extends('layouts.app')

@section('title', 'Detail Pesanan')
@section('page-heading', 'Detail Pesanan')

@push('styles')
<style>
    .detail-container {
        max-width: 950px;
        background: white;
        padding: 28px;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
    }

    .info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .item {
        margin-bottom: 12px;
        overflow-wrap: anywhere;
    }

    .item strong {
        display: block;
        margin-bottom: 5px;
        color: #555;
    }

    .section-title {
        margin-top: 28px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
        font-size: 17px;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        min-width: 550px;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        text-align: left;
    }

    th {
        background: #f8fafc;
        color: #333;
    }

    .total {
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        margin-top: 20px;
        color: #172554;
    }

    .status {
        display: inline-block;
        background: #dbeafe;
        color: #1d4ed8;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
    }

    .back {
        display: inline-block;
        margin-top: 25px;
        padding: 11px 18px;
        background: #e5e7eb;
        color: #333;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
    }

    .back:hover {
        background: #d1d5db;
    }

    @media (max-width: 600px) {
        .info {
            grid-template-columns: 1fr;
        }

        .detail-container {
            padding: 18px;
        }
    }
</style>
@endpush

@section('content')

<div class="detail-container">

    <h2>Detail Pesanan #{{ $order->id }}</h2>
    <p>Informasi lengkap pesanan pelanggan MerchFlow.</p>

    <h3 class="section-title">Informasi Pelanggan</h3>

    <div class="info">
        <div class="item">
            <strong>Nama Pelanggan</strong>
            {{ $order->customer_name }}
        </div>

        <div class="item">
            <strong>Nomor Telepon</strong>
            {{ $order->customer_phone }}
        </div>

        <div class="item">
            <strong>Pengguna</strong>
            {{ $order->user->name }}
        </div>

        <div class="item">
            <strong>Deadline</strong>
            {{ $order->deadline ? \Carbon\Carbon::parse($order->deadline)->format('d-m-Y') : '-' }}
        </div>

        <div class="item">
            <strong>Status Pesanan</strong>
            <span class="status">{{ ucfirst($order->status) }}</span>
        </div>

        <div class="item">
            <strong>Alamat</strong>
            {{ $order->customer_address ?? '-' }}
        </div>
    </div>

    <h3 class="section-title">Produk yang Dipesan</h3>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @php $total = 0; @endphp

                @foreach ($order->orderItems as $item)
                    @php
                        $subtotal = $item->price * $item->quantity;
                        $total += $subtotal;
                    @endphp

                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="total">
        Total: Rp{{ number_format($total, 0, ',', '.') }}
    </div>

    <h3 class="section-title">Catatan</h3>
    <p>{{ $order->notes ?? 'Tidak ada catatan.' }}</p>

    <a href="{{ route('orders.index') }}" class="back">
        Kembali ke Daftar Pesanan
    </a>

</div>

@endsection

