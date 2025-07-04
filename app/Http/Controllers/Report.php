<?php

namespace App\Http\Controllers;

use App\Models\FinanceReports;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;

class Report extends Controller
{
    public function indexFinance(Request $request)
    {
        $query = FinanceReports::query();

        // Saldo berdasarkan source (cash dan bank)
        $cashIncome = FinanceReports::where('source', 'cash')->where('type', 'income')->sum('amount');
        $cashExpense = FinanceReports::where('source', 'cash')->where('type', 'expense')->sum('amount');
        $cashBalance = $cashIncome - $cashExpense;

        $bankIncome = FinanceReports::where('source', 'bank')->where('type', 'income')->sum('amount');
        $bankExpense = FinanceReports::where('source', 'bank')->where('type', 'expense')->sum('amount');
        $bankBalance = $bankIncome - $bankExpense;

        // Total berdasarkan filter (semua jenis source & type)
        $filteredTotal = $cashBalance + $bankBalance;

        return view('report.finance.index', compact(
            'filteredTotal',
            'cashBalance',
            'bankBalance'
        ));
    }

    public function showFinance(string $source, Request $request)
    {
        $query = FinanceReports::query();
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', "%{$request->search}%")
                    ->orWhere('category', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }

        $records = $query->where('source', $source)->orderBy('transaction_date', 'asc')->paginate(31);
        return view('report.finance.show', compact(
            'records',
        ));
    }

    public function printFinance(string $source, Request $request)
    {
        $query = FinanceReports::query();
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', "%{$request->search}%")
                    ->orWhere('category', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }

        $records = $query->where('source', $source)->orderBy('transaction_date', 'asc')->paginate(31);
        return view('report.finance.print', compact(
            'records',
        ));

        // Pilihan 2: jika ingin langsung PDF
        /*
    $pdf = PDF::loadView('report.sales.print_pdf', compact('sales'));
    return $pdf->download('laporan-penjualan.pdf');
    */
    }

    // SALES
    public function indexSales(Request $request)
    {
        $query = Sales::with(['customer.user', 'user']);

        // Filter pencarian umum
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('invoice_number', 'like', "%{$request->search}%")
                    ->orWherefilled('customer.user', function ($q2) use ($request) {
                        $q2->where('name', 'like', "%{$request->search}%");
                    });
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }

        $sales = $query->orderBy('transaction_date', 'asc')->paginate(10);
        // dd($request->all(), $query->toSql());

        return view('report.sales.index', compact('sales', 'request'));
    }

    public function printSales(Request $request)
    {
        $query = Sales::with(['customer.user', 'user']);

        // Filter umum
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('invoice_number', 'like', "%{$request->search}%")
                    ->orWhereHas('customer.user', function ($q2) use ($request) {
                        $q2->where('name', 'like', "%{$request->search}%");
                    });
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }

        $sales = $query->orderBy('transaction_date', 'asc')->get();

        // Pilihan 1: tampilkan view print biasa (HTML print view)
        return view('report.sales.print', compact('sales'));

        // Pilihan 2: jika ingin langsung PDF
        /*
    $pdf = PDF::loadView('report.sales.print_pdf', compact('sales'));
    return $pdf->download('laporan-penjualan.pdf');
    */
    }

    public function indexBestSellingProducts(Request $request)
    {
        $query = Product::withSum(['saleDetails as total_sold' => function ($q) use ($request) {
            // Filter by rentang tanggal atau per bulan
            $q->whereHas('sale', function ($saleQuery) use ($request) {
                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $saleQuery->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
                } elseif ($request->filled('month')) {
                    $saleQuery->whereMonth('transaction_date', $request->month);
                }
            });
        }], 'quantity');

        // Filter berdasarkan nama produk
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $topProducts = $query->orderByDesc('total_sold')
            ->take(10)
            ->get();

        return view('report.best_sellers.index', compact('topProducts', 'request'));
    }


    public function printBestSellingProducts(Request $request)
    {
        $query = Product::withSum(['saleDetails as total_sold' => function ($q) use ($request) {
            // Filter by rentang tanggal atau per bulan
            $q->whereHas('sale', function ($saleQuery) use ($request) {
                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $saleQuery->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
                } elseif ($request->filled('month')) {
                    $saleQuery->whereMonth('transaction_date', $request->month);
                }
            });
        }], 'quantity');

        // Filter berdasarkan nama produk
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $topProducts = $query->orderByDesc('total_sold')
            ->take(10)
            ->get();

        return view('report.best_sellers.print', compact('topProducts'));
    }

    // Low Stock
    public function indexLowStock(Request $request)
    {
        $query = Product::where('stock', '<=', 10);

        // Filter berdasarkan nama produk
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter status
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $lowStockProducts = $query->get();

        return view('report.low_stock.index', compact('lowStockProducts'));
    }

    public function printLowStock(Request $request)
    {
        $query = Product::where('stock', '<=', 10);

        // Filter berdasarkan nama produk
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter status
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $lowStockProducts = $query->get();

        return view('report.low_stock.print', compact('lowStockProducts'));
    }
}
