<?php

namespace App\Http\Controllers;

use App\Models\FinanceReports;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Sales;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Midtrans Webhook Payload: ', $request->all());

        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');

        // Cari data penjualan berdasarkan order_id/invoice_number
        $sale = Sales::where('invoice_number', $orderId)->first();

        if (!$sale) {
            Log::warning("Penjualan tidak ditemukan untuk invoice: $orderId");
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        if ($transactionStatus === 'settlement') {
            $sale->update(['payment_status' => 'dibayar']);

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
            $lastFinance = FinanceReports::where('source', 'bank')->latest()->value('total') ?? 0;
            $total = $sale->total_price + $lastFinance;

            FinanceReports::create([
                'type' => 'income',
                'category' => 'Penjualan',
                'source' => 'bank',
                'amount' => $sale->total_price,
                'transaction_date' => now(),
                'description' => 'Pemasukan dari penjualan invoice #' . $sale->invoice_number,
                'total' => $total
            ]);

            Order::create([
                'sale_id' => $sale->id,
            ]);

            Log::info("Pembayaran berhasil untuk invoice: $orderId");
        }

        return response()->json(['message' => 'Webhook received']);
    }
}
