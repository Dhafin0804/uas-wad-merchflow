<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    // Menampilkan semua produk
    public function index(): View
    {
        $products = Product::with('category')
            ->latest()
            ->get();

        return view('products.index', compact('products'));
    }

    // Menampilkan form tambah produk
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    // Menyimpan produk baru
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    // Menampilkan form edit produk
    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    // Memperbarui produk
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    // Menghapus produk
    public function destroy(Product $product): RedirectResponse
    {
        // Periksa apakah produk sudah digunakan dalam pesanan
        if ($product->orderItems()->exists()) {
            return redirect()
                ->route('products.index')
                ->with(
                    'error',
                    'Produk tidak dapat dihapus karena sudah digunakan dalam pesanan.'
                );
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}

