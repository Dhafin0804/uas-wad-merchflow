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
    public function index()
    {
        $orders = Order::with('user')->latest()->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $users = User::all();
        $products = Product::where('is_active', true)->get();

        return view('orders.create', compact('users', 'products'));
    }

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

        $product = Product::findOrFail($validated['product_id']);

        if (!$product->is_active) {
            return back()->withInput()
                ->withErrors(['product_id' => 'Produk tidak aktif.']);
        }

        if ($validated['quantity'] > $product->stock) {
            return back()->withInput()
                ->withErrors(['quantity' => 'Jumlah melebihi stok produk.']);
        }

        DB::transaction(function () use ($validated, $product) {
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'] ?? null,
                'deadline' => $validated['deadline'] ?? null,
                'status' => 'baru',
                'notes' => $validated['notes'] ?? null,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'price' => $product->price,
            ]);

            $product->decrement('stock', $validated['quantity']);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil ditambahkan!');
    }

    public function show(string $id)
    {
         $order = Order::with(['user', 'orderItems.product'])
        ->findOrFail($id);

    	return view('orders.show', compact('order'));
    }

    public function edit(string $id)
    {
         $order = Order::with('orderItems.product')->findOrFail($id);

    	return view('orders.edit', compact('order'));
    }

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

    $order = Order::findOrFail($id);

    $order->update($validated);

    return redirect()
        ->route('orders.index')
        ->with('success', 'Pesanan berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
         $order = Order::findOrFail($id);

    DB::transaction(function () use ($order) {

        foreach ($order->orderItems as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        $order->delete();
    });

    return redirect()
        ->route('orders.index')
        ->with('success', 'Pesanan berhasil dihapus!');
    }
}
