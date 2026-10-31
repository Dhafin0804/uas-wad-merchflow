
@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-heading', 'Dashboard')

@push('styles')
<style>
    .welcome {
        background: linear-gradient(120deg, #1e40af, #3b82f6);
        color: white;
        padding: 28px;
        border-radius: 14px;
        margin-bottom: 28px;
    }

    .welcome h1 {
        font-size: 25px;
        margin-bottom: 9px;
    }

    .welcome p {
        color: #dbeafe;
        font-size: 14px;
    }

    .section-title {
        font-size: 17px;
        margin-bottom: 17px;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 23px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }

    .stat-card p {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 13px;
    }

    .stat-card h2 {
        font-size: 29px;
        color: #172554;
    }

    .stat-icon {
        font-size: 22px;
        margin-bottom: 12px;
    }

    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 18px;
    }

    .panel {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 23px;
        min-width: 0;
    }

    .status-item {
        display: flex;
        justify-content: space-between;
        padding: 13px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
    }

    .status-item:last-child {
        border-bottom: none;
    }

    .status-count {
        color: #2563eb;
        font-weight: bold;
    }

    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        text-align: left;
    }

    th {
        color: #64748b;
        background: #f8fafc;
        font-weight: 600;
    }

    th, td {
        padding: 14px 10px;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 11px;
    }

    .empty {
        color: #94a3b8;
        text-align: center;
        padding: 20px;
    }

    @media (max-width: 900px) {
        .stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .bottom-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .stats {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

    <!-- Welcome -->
    <div class="welcome">
        <h1>Selamat Datang di MerchFlow!</h1>
        <p>
            Kelola produk, kategori, dan pesanan merchandise dalam satu tempat.
        </p>
    </div>

    <!-- Statistik -->
    <h3 class="section-title">Ringkasan Bisnis</h3>

    <div class="stats">

        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <p>Total Produk</p>
            <h2>{{ $totalProducts }}</h2>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🏷️</div>
            <p>Total Kategori</p>
            <h2>{{ $totalCategories }}</h2>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🛍️</div>
            <p>Total Pesanan</p>
            <h2>{{ $totalOrders }}</h2>
        </div>

    </div>

    <!-- Informasi Pesanan -->
    <div class="bottom-grid">

        <!-- Status Pesanan -->
        <div class="panel">
            <h3 class="section-title">Status Pesanan</h3>

            @forelse ($ordersByStatus as $status)
                <div class="status-item">
                    <span>{{ ucfirst($status->status) }}</span>

                    <span class="status-count">
                        {{ $status->total }} pesanan
                    </span>
                </div>
            @empty
                <p class="empty">Belum ada data pesanan.</p>
            @endforelse
        </div>

        <!-- Pesanan Terbaru -->
        <div class="panel">
            <h3 class="section-title">Pesanan Terbaru</h3>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($latestOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>
                                    <span class="status-badge">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty">
                                    Belum ada pesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

