
@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('page-heading', 'Edit Kategori')

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
        font-size: 14px;
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
        min-height: 120px;
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
        padding: 12px 16px;
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
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 28px;
    }

    .btn {
        display: inline-block;
        padding: 12px 18px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-back {
        background: #e2e8f0;
        color: #334155;
    }

    .btn-save {
        background: #2563eb;
        color: white;
    }

    .btn:hover {
        opacity: 0.85;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-card">
        <h2>Edit Kategori</h2>

        <p class="form-subtitle">
            Perbarui informasi kategori merchandise.
        </p>

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

        <form action="{{ route('categories.update', $category->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Kategori</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    placeholder="Masukkan nama kategori"
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
                    placeholder="Masukkan deskripsi kategori"
                >{{ old('description', $category->description) }}</textarea>

                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('categories.index') }}"
                   class="btn btn-back">
                    Batal
                </a>

                <button type="submit" class="btn btn-save">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

