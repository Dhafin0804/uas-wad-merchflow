<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan seluruh pesanan.
     */
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan form pembuatan pesanan.
     */
    public function create()
    {
        $users = User::all();

        $products = Product::where('is_active', true)
            ->get();

        return view('orders.create', compact('users', 'products'));
    }

    /**
     * Menyimpan pesanan baru dan mengurangi stok produk.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'customer_name' => 'required|string|max:150',
            'customer_phone' => 'required|string|max:25',
            'customer_address' => 'nullable|string',
            'deadline' => 'nullable|date',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $result = DB::transaction(function () use ($validated) {

            // Mengunci produk selama transaksi berlangsung.
            $product = Product::where('id', $validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Memastikan produk masih aktif.
            if (!$product->is_active) {
                return 'inactive';
            }

            // Memastikan stok masih mencukupi.
            if ($validated['quantity'] > $product->stock) {
                return 'insufficient_stock';
            }

            // Membuat data pesanan.
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'] ?? null,
                'deadline' => $validated['deadline'] ?? null,
                'status' => 'baru',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Membuat detail pesanan.
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'price' => $product->price,
            ]);

            // Mengurangi stok produk.
            $product->decrement('stock', $validated['quantity']);

            return 'success';
        });

        if ($result === 'inactive') {
            return back()->withInput()
                ->withErrors([
                    'product_id' => 'Produk tidak aktif.',
                ]);
        }

        if ($result === 'insufficient_stock') {
            return back()->withInput()
                ->withErrors([
                    'quantity' => 'Jumlah melebihi stok produk.',
                ]);
        }

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pesanan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function show(string $id)
    {
        $order = Order::with([
            'user',
            'orderItems.product',
        ])->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Menampilkan form edit pesanan.
     */
    public function edit(string $id)
    {
        $order = Order::with('orderItems.product')
            ->findOrFail($id);

        return view('orders.edit', compact('order'));
    }

    /**
     * Memperbarui pesanan dan mengatur stok berdasarkan status.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:150',
            'customer_phone' => 'required|string|max:25',
            'customer_address' => 'nullable|string',
            'deadline' => 'nullable|date',
            'status' => 'required|in:baru,dikonfirmasi,diproses,selesai,dibatalkan',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $id) {

            // Mengunci data pesanan.
            $order = Order::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $oldStatus = $order->status;
            $newStatus = $validated['status'];

            // Jika pesanan aktif dibatalkan, kembalikan stok.
            if ($oldStatus !== 'dibatalkan' && $newStatus === 'dibatalkan') {

                foreach ($order->orderItems as $item) {
                    $product = Product::where('id', $item->product_id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    $product->increment('stock', $item->quantity);
                }
            }

            // Jika pesanan dibatalkan diaktifkan kembali, kurangi stok.
            if ($oldStatus === 'dibatalkan' && $newStatus !== 'dibatalkan') {

                foreach ($order->orderItems as $item) {
                    $product = Product::where('id', $item->product_id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    // Pastikan stok mencukupi.
                    if ($item->quantity > $product->stock) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'status' => 'Stok produk ' . $product->name . ' tidak mencukupi untuk mengaktifkan kembali pesanan.',
                        ]);
                    }

                    $product->decrement('stock', $item->quantity);
                }
            }

            // Memperbarui data pesanan.
            $order->update($validated);
        });

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pesanan berhasil diperbarui!');
    }

    /**
     * Menghapus pesanan dan mengembalikan stok jika pesanan masih aktif.
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {

            // Mengunci data pesanan.
            $order = Order::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            // Stok hanya dikembalikan jika pesanan belum dibatalkan.
            if ($order->status !== 'dibatalkan') {

                foreach ($order->orderItems as $item) {
                    $product = Product::where('id', $item->product_id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    $product->increment('stock', $item->quantity);
                }
            }

            // Menghapus pesanan.
            $order->delete();
        });

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pesanan berhasil dihapus!');
    }
}

