
@extends('layouts.app')

@section('title', 'Daftar Pesanan')
@section('page-heading', 'Daftar Pesanan')

@push('styles')
<style>
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .top-bar h2 {
        margin: 0 0 6px;
    }

    .subtitle {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    .btn {
        display: inline-block;
        padding: 9px 13px;
        border-radius: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 13px;
        white-space: nowrap;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-edit {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .btn-detail {
        background: #e2e8f0;
        color: #334155;
    }

    .btn-delete {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn:hover {
        opacity: 0.85;
    }

    .table-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        overflow-x: auto;
        box-shadow: 0 3px 12px rgba(0,0,0,0.05);
        border: 1px solid #e5e7eb;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }

    th, td {
        padding: 14px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
        font-size: 14px;
    }

    th {
        color: #64748b;
        background: #f8fafc;
    }

    .status {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        background: #fef3c7;
        color: #92400e;
        font-size: 12px;
    }

    .success {
        background: #dcfce7;
        color: #166534;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .error {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .empty {
        text-align: center;
        padding: 35px;
        color: #64748b;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: nowrap;
    }

    .action-buttons form {
        display: inline;
        margin: 0;
    }

    @media (max-width: 600px) {
        .top-bar {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')

    <!-- Judul halaman dan tombol tambah -->
    <div class="top-bar">
        <div>
            <h2>Daftar Pesanan</h2>
            <p class="subtitle">
                Kelola seluruh pesanan merchandise.
            </p>
        </div>

        <a href="{{ route('orders.create') }}" class="btn btn-primary">
            + Tambah Pesanan
        </a>
    </div>

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tabel Pesanan -->
    <div class="table-card">

        @if ($orders->isEmpty())

            <div class="empty">
                <h3>Belum Ada Pesanan</h3>
                <p>
                    Pesanan yang dibuat akan ditampilkan di halaman ini.
                </p>
            </div>

        @else

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pelanggan</th>
                        <th>No. Telepon</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>

                            <td>{{ $order->customer_name }}</td>

                            <td>{{ $order->customer_phone }}</td>

                            <td>
                                {{ $order->deadline
                                    ? \Carbon\Carbon::parse($order->deadline)->format('d-m-Y')
                                    : '-' }}
                            </td>

                            <td>
                                <span class="status">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="action-buttons">

                                    <a href="{{ route('orders.show', $order->id) }}"
                                       class="btn btn-detail">
                                        Detail
                                    </a>

                                    <a href="{{ route('orders.edit', $order->id) }}"
                                       class="btn btn-edit">
                                        Edit
                                    </a>

                                    <!-- Hapus hanya untuk Admin -->
                                    @if (auth()->user()->isAdmin())

                                        <form
                                            action="{{ route('orders.destroy', $order->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-delete">
                                                Hapus
                                            </button>

                                        </form>

                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @endif

    </div>

@endsection




