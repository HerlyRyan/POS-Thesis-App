<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
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
        $cart = $this->getCart();

        $cart->load('cartItems');

        if ($cart->cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        DB::transaction(function () use ($cart, $request) {
            $user = auth()->guard()->user();
            $total = $cart->cartItems->sum('subtotal');

            $today = now()->format('mdy');
            $random = strtoupper(Str::random(4));
            $invoiceNumber = 'INVGS-' . $today . '-' . $random;

            $sale = Sales::create([
                'invoice_number' => $invoiceNumber,
                'customer_id' => optional($user->customer)->id,
                'user_id' => $user->id,
                'total_price' => $total,
                'payment_method' => $request->input('payment_method', 'cash'),
                'payment_status' => 'belum dibayar',
                'transaction_date' => now(),
                'note' => $request->note,
            ]);

            foreach ($cart->cartItems as $item) {
                $sale->details()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);
            }

            // Kosongkan keranjang
            $cart->cartItems()->delete();
            $cart->delete();
        });

        return redirect()->route('customer.cart.index')->with('success', 'Transaksi berhasil disimpan');
    }
}
