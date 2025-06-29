<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\FinanceReports;
use App\Models\Product;
use App\Models\SaleDetail;
use App\Models\Sales;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SalesController extends Controller
{
    public function index(Request $request): View
    {
        $query = Sales::with('customer'); // Add relationship loading
        $columns = Schema::getColumnListing('sales');

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('invoice_number', 'like', "%{$request->search}%")
                    ->orWhereHas('customer', function ($query) use ($request) {
                        $query->where('name', 'like', "%{$request->search}%");
                    });
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('payment_status', $request->status);
        }

        $sales = $query->paginate(5);

        return view('admin.sales.index', compact('sales', 'columns'));
    }

    public function create()
    {
        $today = now()->format('mdy');

        $lastSale = Sales::whereDate('created_at', today())
            ->where('invoice_number', 'like', 'INVGS-' . $today . '%')
            ->latest()
            ->first();

        $lastCounter = $lastSale ? intval(substr($lastSale->invoice_number, -2)) : 0;
        $todayCounter = $lastCounter + 1;

        $invoiceNumber = 'INVGS-' . $today . str_pad($todayCounter, 2, '0', STR_PAD_LEFT);

        $products = Product::all();
        $customers = Customer::all();
        return view('admin.sales.create', compact('products', 'customers', 'invoiceNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,transfer,ewallet',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        // Hitung total dan siapkan detail penjualan
        $totalPrice = 0;
        $details = [];

        foreach ($request->products as $item) {
            $product = Product::findOrFail($item['product_id']);
            $quantity = $item['quantity'];
            $subtotal = $product->price * $quantity;

            if ($product->stock < $quantity) {
                return redirect()->back()->withErrors(['stock' => "Stok untuk {$product->name} tidak mencukupi."]);
            }

            $details[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];

            $totalPrice += $subtotal;
        }

        // Ambil customer_id dari user login (jika role customer) atau dari input admin
        $user = $request->user();
        if ($user->hasRole('customer')) {
            $customer_id = $user->customer->id ?? null;
        } else {
            $customer_id = $request->customer_id;
        }

        // Simpan penjualan
        $sale = Sales::create([
            'invoice_number' => $request->invoice,
            'customer_id' => $customer_id,
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
            'payment_status' => 'belum dibayar',
            'transaction_date' => now(),
        ]);

        // Simpan detail penjualan
        foreach ($details as $detail) {
            $sale->details()->create($detail);
        }

        return redirect()->route('admin.sales.index')->with('success', 'Penjualan berhasil disimpan.');
    }

    public function show(Sales $sale)
    {
        $sale->load(['customer', 'user', 'details']);
        return view('admin.sales.show', compact('sale'));
    }

    public function destroy($id): RedirectResponse
    {
        // Ambil data sales
        $sale = Sales::findOrFail($id);

        // Ambil semua detail penjualan
        $saleDetails = $sale->details; // Asumsikan relasi `details()` sudah ada di model Sales

        // Kembalikan stok untuk setiap produk
        foreach ($saleDetails as $detail) {
            $product = Product::find($detail->product_id);
            if ($product) {
                $product->increment('stock', $detail->quantity);
            }
        }

        // Hapus data sales
        $sale->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.sales.index')->with(['success' => 'Data penjualan berhasil dihapus dan stok dikembalikan.']);
    }

    public function payment_confirmation($id): RedirectResponse
    {
        // Wrap all database operations in a transaction
        return DB::transaction(function () use ($id) {
            // Ambil data sales
            $sale = Sales::findOrFail($id);
            
            $sale->update([
                'payment_status' => 'dibayar'
            ]);
            
            // Ambil semua detail penjualan
            $saleDetails = $sale->details;
            
            // Kurangi stok untuk setiap produk
            foreach ($saleDetails as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    $product->decrement('stock', $detail->quantity);
                }
            }
            
            // Tambahkan ke laporan keuangan
            $lastFinance = FinanceReports::where('source', 'cash')->latest()->value('total') ?? 0;
            $total = $sale->total_price + $lastFinance;       
            
            FinanceReports::create([
                'type' => 'income',
                'category' => 'Penjualan',
                'source' => 'cash',
                'amount' => $sale->total_price,
                'transaction_date' => now(),
                'description' => 'Pemasukan dari penjualan invoice #' . $sale->invoice_number,
                'total' => $total
            ]);
            
            // Return redirect response
            return redirect()->route('admin.sales.index')
                ->with(['success' => 'Pembayaran Berhasil Di Konfirmasi']);
        });
    }
}
