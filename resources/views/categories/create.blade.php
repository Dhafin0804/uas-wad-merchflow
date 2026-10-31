
@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page-heading', 'Tambah Kategori')

@push('styles')
<style>
    .form-container {
        max-width: 700px;
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

    .btn-secondary {
        background: #e5e7eb;
        color: #374151;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-card">
        <h2>Tambah Kategori</h2>

        <p class="form-subtitle">
            Tambahkan kategori baru untuk produk merchandise.
        </p>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Kategori</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Jaket"
                    required
                >

                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>

                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Jelaskan kategori produk ini"
                >{{ old('description') }}</textarea>

                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Simpan Kategori
                </button>

                <a
                    class="btn btn-secondary"
                    href="{{ route('categories.index') }}"
                >
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

