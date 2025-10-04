<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\FinanceReports;
use App\Models\Order;
use App\Models\Product;
use App\Models\Receivable;
use App\Models\SaleDetail;
use App\Models\Sales;
use App\Models\SalesPromotion;
use App\Services\MidtransService;
use App\Services\FonnteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
class SalesController extends Controller
{
    protected $fonnte;

    public function __construct(FonnteService $fonnte)
    {
        $this->fonnte = $fonnte;
    }

    public function index(Request $request): View
    {
        $query = Sales::with('customer'); // Add relationship loading
        $columns = Schema::getColumnListing('sales');

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('invoice_number', 'like', "%{$request->search}%")
                    ->orWhereHas('customer.user', function ($query) use ($request) {
                        $query->where('name', 'like', "%{$request->search}%");
                    });
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('payment_status', $request->status);
        }

        $sales = $query->orderBy('transaction_date', 'desc')->paginate(5);

        return view('admin.sales.index', compact('sales', 'columns'));
    }

    public function create()
    {
        $today = now()->format('mdy');

        $lastSale = Sales::whereDate('created_at', today())
            ->where('invoice_number', 'like', 'INVGS-' . $today . '%')
            ->latest()
            ->first();

        $random = strtoupper(Str::random(4));

        $invoiceNumber = 'INVGS-' . $today . '-' . $random;

        $products = Product::all();
        $customers = Customer::all();
        
        // Get active promotions
        $promotions = SalesPromotion::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();
            
        return view('admin.sales.create', compact('products', 'customers', 'invoiceNumber', 'promotions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,transfer,ewallet',
            'customer_id' => 'nullable|exists:customers,id',
            'promotion_id' => 'nullable|exists:sales_promotions,id',
        ]);

        return DB::transaction(function () use ($request) {
            $user = $request->user();
            
            // Get product IDs for bulk query
            $productIds = array_column($request->products, 'product_id');
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
            
            // Validate customer
            if ($user->hasRole('customer')) {
                $customer = $user->customer;
            } else {
                $customer = $request->customer_id ? Customer::find($request->customer_id) : null;
            }

            if ($request->customer_id && !$customer) {
                throw new \Exception('Pelanggan tidak ditemukan.');
            }

            // Validate promotion once
            $promotion = null;
            $discountPercentage = 0;
            
            if ($request->promotion_id) {
                $promotion = SalesPromotion::find($request->promotion_id);
                if (!$promotion) {
                    throw new \Exception('Promo tidak ditemukan.');
                }
                $discountPercentage = $promotion->discount_percentage;
            }

            // Calculate totals and prepare details in single loop
            $totalPrice = 0;
            $details = [];

            foreach ($request->products as $item) {
                $product = $products->get($item['product_id']);
                
                if (!$product) {
                    throw new \Exception('Produk tidak ditemukan.');
                }

                $quantity = $item['quantity'];
                
                if ($product->stock < $quantity) {
                    throw new \Exception("Stok untuk {$product->name} tidak mencukupi.");
                }

                $subtotal = $product->price * $quantity;
                $totalPrice += $subtotal;

                $details[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
            }

            // Apply discount to total
            $discountAmount = $promotion ? ($discountPercentage / 100) * $totalPrice : 0;
            $grandTotal = max(0, $totalPrice - $discountAmount);

            // Prepare sale data
            $saleData = [
                'invoice_number' => $request->invoice,
                'customer_id' => $customer->id,
                'user_id' => $user->id,
                'promotion_id' => $promotion?->id,
                'total_price' => $totalPrice,
                'discount' => $discountAmount,
                'grand_price' => $grandTotal,
                'payment_method' => $request->payment_method,
                'payment_status' => 'menunggu pembayaran',
                'transaction_date' => now(),
            ];

            // Handle payment method specific logic
            if ($request->payment_method === 'transfer') {
                $midtrans = new MidtransService();
                
                $params = [
                    'transaction_details' => [
                        'order_id' => $request->invoice,
                        'gross_amount' => $grandTotal,
                    ],
                    'customer_details' => [
                        'first_name' => $user->name ?? 'Pelanggan',
                        'email' => $user->email ?? 'email@example.com',
                    ],
                ];

                $snap = $midtrans->createTransaction($params);
                $saleData['snap_url'] = $snap->redirect_url;
            }

            // Create sale
            $sale = Sales::create($saleData);

            // Bulk insert sale details
            $detailsWithSaleId = array_map(function ($detail) use ($sale) {
                $detail['sale_id'] = $sale->id;
                $detail['created_at'] = now();
                $detail['updated_at'] = now();
                return $detail;
            }, $details);

            SaleDetail::insert($detailsWithSaleId);

            return redirect()->route('admin.sales.index')
                ->with('success', 'Penjualan berhasil disimpan.');
        });
    }

    public function show(Sales $sale)
    {
        $sale->load(['customer', 'user', 'details']);
        return view('admin.sales.show', compact('sale'));
    }

    public function cancel($id): RedirectResponse
    {
        // Ambil data sales
        $sale = Sales::findOrFail($id);

        if ($sale->payment_method == 'cod' && $sale->payment_status == 'menunggu pembayaran') {
            $saleDetails = $sale->details;

            // Tambah stok untuk setiap produk
            foreach ($saleDetails as $detail) {
                $product = Product::find($detail->product_id);
                $product->increment('stock', $detail->quantity);
            }
        }

        $sale->update([
            'payment_status' => 'cancelled'
        ]);

        Order::where('sale_id', $sale->id)->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.sales.index')->with(['success' => 'Data penjualan berhasil dibatalkan.']);
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

            if ($sale->payment_method == 'cash') {
                // Kurangi stok untuk setiap produk
                foreach ($saleDetails as $detail) {
                    $product = Product::find($detail->product_id);
                    if ($product && $product->stock >= 10) {
                        $product->decrement('stock', $detail->quantity);
                    }
                    
                    if ($product && $product->stock <= 10) {
                        $message = "⚠️ *Stok Menipis*\nProduk: {$product->name}\nStok saat ini: {$product->stock}\nMinimum: {$product->minimum_stock}\nSegera lakukan pemesanan ulang!";
                        $this->fonnte->sendMessage('085821331091', $message);
                    }
                }

                Order::create([
                    'sale_id' => $sale->id,
                ]);
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

            // Update status Receivable (Piutang)
            $receivable = Receivable::where('sale_id', $sale->id);
            $remaining = $sale->total_price - $sale->total_price;
            $receivable->update([
                'status' => 'paid',
                'paid_amount' => $sale->total_price,
                'remaining_amount' => $remaining,
            ]);

            // Return redirect response
            return redirect()->route('admin.sales.index')
                ->with(['success' => 'Pembayaran Berhasil Di Konfirmasi']);
        });
    }

    public function cod_confirmation($id): RedirectResponse
    {
        // Wrap all database operations in a transaction
        return DB::transaction(function () use ($id) {
            // Ambil data sales
            $sale = Sales::findOrFail($id);

            $sale->update([
                'payment_status' => 'menunggu pembayaran'
            ]);

            // Ambil semua detail penjualan
            $saleDetails = $sale->details;

            // Kurangi stok untuk setiap produk
            foreach ($saleDetails as $detail) {
                $product = Product::find($detail->product_id);
                if ($product && $product->stock >= 10) {
                    $product->decrement('stock', $detail->quantity);
                }
                if ($product->stock <= 10) {
                    $message = "⚠️ *Stok Menipis*\nProduk: {$product->name}\nStok saat ini: {$product->stock}\nMinimum: {$product->minimum_stock}\nSegera lakukan pemesanan ulang!";
                    $this->fonnte->sendMessage('085821331091', $message);
                }
            }

            // Create Order
            Order::create([
                'sale_id' => $sale->id,
            ]);

            // Create Receivable (Piutang)
            Receivable::create([
                'sale_id' => $sale->id,
                'customer_id' => $sale->customer_id,
                'total_amount' => $sale->total_price,
                'remaining_amount' => $sale->total_price,
                'status' => 'unpaid',
                'due_date' => now()->addDays(7), // contoh jatuh tempo 7 hari
            ]);

            // Return redirect response
            return redirect()->route('admin.sales.index')
                ->with(['success' => 'Pembayaran Berhasil Di Konfirmasi']);
        });
    }

    public function printInvoice($saleId)
    {
        $sale = Sales::with(['details', 'customer', 'user', 'promotion'])->findOrFail($saleId);
        return view('admin.sales.print-invoice', compact('sale'));
        // Or to stream directly to browser:
        // return $pdf->stream('invoice-' . $sale->invoice_number . '.pdf');
    }
}
