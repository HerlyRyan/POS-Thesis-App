<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ECommerceController extends Controller
{
    // Ambil keranjang aktif milik user (kasir)
    private function getCart(bool $createIfNotExists = false)
    {
        $user = auth()->guard()->user();

        if ($createIfNotExists) {
            return Cart::firstOrCreate(['user_id' => $user->id]);
        }

        return Cart::where('user_id', $user->id)->first();
    }


    public function index(Request $request)
    {
        $query = Product::query();
        $products = $query->paginate(10);

        return view('welcome', compact('products'));
    }

    public function cartIndex(Request $request)
    {
        $cart = $this->getCart();

        if (!$cart) {
            return view('customer.cart', ['cart' => null]);
        }

        $cart->load('cartItems');

        return view('customer.cart', compact('cart'));
    }

    // Tambah produk ke keranjang
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = $this->getCart(true);

        $item = $cart->cartItems()->where('product_id', $product->id)->first();

        if ($item) {
            // Jika sudah ada, update qty
            $item->quantity += $request->quantity;
            $item->subtotal = $item->quantity * $item->price;
            $item->save();
        } else {
            // Tambah item baru
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'subtotal' => $product->price * $request->quantity,
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    // Update quantity item di keranjang
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = CartItems::findOrFail($id);
        $item->quantity = $request->quantity;
        $item->subtotal = $item->price * $request->quantity;
        $item->save();

        return back()->with('success', 'Item diperbarui');
    }

    // Hapus item dari keranjang
    public function destroy($id)
    {
        $item = CartItems::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Item dihapus dari keranjang');
    }

    // Proses checkout → simpan ke sales dan sale_details
    public function checkout(Request $request)
    {
        $user = auth()->guard()->user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return back()->with('error', 'Keranjang tidak ditemukan');
        }

        $cart->load('cartItems');

        $selectedIds = explode(',', $request->selected_items);

        $selectedItems = $cart->cartItems->whereIn('id', $selectedIds);

        if ($selectedItems->isEmpty()) {
            return back()->with('error', 'Tidak ada item yang dipilih.');
        }

        DB::transaction(function () use ($user, $selectedItems, $request) {
            $total = $selectedItems->sum('subtotal');

            $invoiceNumber = 'INVGS-' . now()->format('mdy') . '-' . strtoupper(Str::random(4));

            $sale = Sales::create([
                'invoice_number' => $invoiceNumber,
                'customer_id' => $user->customer->id,
                'user_id' => null,
                'total_price' => $total,
                'payment_method' => $request->input('payment_method', 'cash'),
                'payment_status' => 'belum dibayar',
                'transaction_date' => now(),
                'note' => $request->note,
            ]);

            foreach ($selectedItems as $item) {
                $sale->details()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);

                $item->delete();
            }

        });
        $cart->delete();

        return redirect()->route('customer.cart.index')->with('success', 'Checkout berhasil');
    }

    public function ordersIndex(Request $request){
        $status = $request->input('status', 'belum_dibayar');

        $orders = Sales::with(['details', 'orders'])
            ->where('customer_id', auth()->guard()->user()->customer->id)
            ->when($status === 'belum_dibayar', fn($q) => $q->where('payment_status', 'belum dibayar'))
            ->when(in_array($status, ['draft', 'persiapan', 'pengiriman', 'selesai']), function ($q) use ($status) {
                $q->whereHas('orders', function ($query) use ($status) {
                    $query->where('status', $status);
                });
            })
            ->latest('transaction_date')
            ->get();

        return view('customer.orders', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Sales::with(['details', 'orders'])->findOrFail($id);            
        // Optional: cek apakah ini milik user yang sedang login
        if ($order->customer_id !== auth()->guard()->user()->customer->id) {
            abort(403);
        }

        return view('customer.show-order', compact('order'));
    }

    public function markAsCompleted($id)
    {
        $user = auth()->guard()->user();

        $order = Order::with('sale')->findOrFail($id);

        // Validasi: hanya pemilik pesanan yang bisa konfirmasi
        if ($order->sale->customer_id !== $user->customer->id) {
            abort(403);
        }

        if ($order->status !== 'pengiriman') {
            return redirect()->back()->withErrors(['msg' => 'Pesanan belum dalam status pengiriman.']);
        }

        // Update status order
        $order->update(['status' => 'selesai']);

        // Update status truk dan supir
        if ($order->truck) {
            $order->truck->update(['status' => 'tersedia']);
        }

        if ($order->driver) {
            $order->driver->update(['status' => 'tersedia']);
        }

        return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi selesai.');
    }
}
