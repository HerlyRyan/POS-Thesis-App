<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employees;
use App\Models\FinanceReports;
use App\Models\Order;
use App\Models\Payable;
use App\Models\Product;
use App\Models\Receivable;
use App\Models\SaleDetail;
use App\Models\Sales;
use App\Models\SalesPromotion;
use App\Models\SalesTarget;
use App\Models\Truck;
use Carbon\Carbon;

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

        // Receivable
        $paid_receivables = Receivable::sum('paid_amount');
        $remaining_receivables = Receivable::sum('remaining_amount');
        $total_receivables = Receivable::sum('total_amount');

        // Payable
        $paid_payables = Payable::sum('installment_amount');
        $remaining_payables = Payable::sum('remaining_amount');
        $total_payables = Payable::sum('total_amount');

        // Total berdasarkan filter (semua jenis source & type)
        $filteredTotal = $cashBalance + $bankBalance;

        return view('report.finance.index', compact(
            'filteredTotal',
            'cashBalance',
            'bankBalance',
            'paid_receivables',
            'remaining_receivables',
            'total_receivables',
            'paid_payables',
            'remaining_payables',
            'total_payables',
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
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('transaction_date', [$start, $end]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('transaction_date', $request->year);
        }

        $records = $query->where('source', $source)->orderBy('transaction_date', 'asc')->paginate(31);
        return view('report.finance.show-finance', compact(
            'records',
        ));
    }

    public function showReceivable(Request $request)
    {
        $query = Receivable::with(['sale', 'customer']);
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->whereHas('user', function ($q2) use ($request) {
                    $q2->where('name', 'like', "%{$request->search}%");
                });
            });
        }


        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $receivables = $query->paginate(10);
        return view('report.finance.show-receivable', compact('receivables'));
    }

    public function showPayable(Request $request)
    {
        $query = Payable::latest();
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('lender_name', 'LIKE', "%{$search}%");
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $payables = $query->paginate(10);
        return view('report.finance.show-payable', compact('payables'));
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
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('transaction_date', [$start, $end]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('transaction_date', $request->year);
        }

        $records = $query->where('source', $source)->orderBy('transaction_date', 'asc')->get();
        return view('report.finance.print-finance', compact(
            'records',
        ));

        // Pilihan 2: jika ingin langsung PDF
        /*
    $pdf = PDF::loadView('report.sales.print_pdf', compact('sales'));
    return $pdf->download('laporan-penjualan.pdf');
    */
    }

    public function printReceivable(Request $request)
    {
        $query = Receivable::with(['sale', 'customer']);
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->whereHas('user', function ($q2) use ($request) {
                    $q2->where('name', 'like', "%{$request->search}%");
                });
            });
        }


        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $receivables = $query->get();

        return view('report.finance.print-receivable', compact(
            'receivables',
        ));

        // Pilihan 2: jika ingin langsung PDF
        /*
    $pdf = PDF::loadView('report.sales.print_pdf', compact('sales'));
    return $pdf->download('laporan-penjualan.pdf');
    */
    }

    public function printPayable(Request $request)
    {
        $query = Payable::latest();
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('lender_name', 'LIKE', "%{$search}%");
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $payables = $query->get();

        return view('report.finance.print-payable', compact(
            'payables',
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
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('invoice_number', 'like', "%{$request->search}%")
                    ->orWhereHas('customer', function ($q) use ($request) {
                        $q->whereHas('user', function ($q2) use ($request) {
                            $q2->where('name', 'like', "%{$request->search}%");
                        });
                    });
            });
        }


        // Filter status
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('transaction_date', [$start, $end]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('transaction_date', $request->year);
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
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('transaction_date', [$start, $end]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('transaction_date', $request->year);
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

    // Business Growth
    public function indexBusinessGrowth(Request $request)
    {
        $query = Sales::with(['customer.user', 'user'])->where('payment_status', 'dibayar');

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('transaction_date', [$start, $end]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('transaction_date', $request->year);
        }

        // ==============================
        // Hitung Total Penjualan (Omzet)
        // ==============================
        $totalPenjualan = (clone $query)->sum('grand_price');

        // ==============================
        // Hitung Total Modal
        // ==============================
        $totalModal = SaleDetail::join('products', 'sale_details.product_id', '=', 'products.id')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->when($request->filled('start_date') && $request->filled('end_date'), function ($q) use ($request) {
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end = Carbon::parse($request->end_date)->endOfDay();
                $q->whereBetween('sales.transaction_date', [$start, $end]);
            })
            ->when($request->filled('month'), function ($q) use ($request) {
                $q->whereMonth('sales.transaction_date', $request->month);
            })
            ->when($request->filled('year'), function ($q) use ($request) {
                $q->whereYear('sales.transaction_date', $request->year);
            })
            ->selectRaw('SUM(products.cost_price * sale_details.quantity) as modal')
            ->value('modal');

        // ==============================
        // Hitung Laba (Omzet - Modal)
        // ==============================
        $totalLaba = $totalPenjualan - $totalModal;

        // ==============================
        // Hitung Utang & Piutang
        // ==============================
        $totalUtang = Payable::when($request->filled('year'), fn($q) => $q->whereYear('created_at', $request->year))
            ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', $request->month))
            ->sum('total_amount');

        $totalPiutang = Receivable::when($request->filled('year'), fn($q) => $q->whereYear('created_at', $request->year))
            ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', $request->month))
            ->sum('total_amount');

        // ==============================
        // Ambil data penjualan per bulan
        // ==============================
        $salesChart = (clone $query)
            ->selectRaw('YEAR(transaction_date) as tahun, MONTH(transaction_date) as bulan, SUM(grand_price) as total')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Normalisasi data: semua bulan ada
        $year = $request->year ?? now()->year;
        $labels = [];
        $values = [];

        for ($m = 1; $m <= 12; $m++) {
            $labels[] = Carbon::create()->month($m)->format('F'); // Nama bulan full
            $row = $salesChart->firstWhere('bulan', $m);
            $values[] = $row ? $row->total : 0;
        }

        return view('report.business-overview.index', [
            'totalPenjualan' => $totalPenjualan,
            'totalModal'     => $totalModal,
            'totalLaba'      => $totalLaba,
            'totalUtang'     => $totalUtang,
            'totalPiutang'   => $totalPiutang,
            'labels'         => $labels,
            'values'         => $values,
            'request'        => $request
        ]);
    }

    public function printBusinessGrowth(Request $request)
    {
        $query = Sales::with(['customer.user', 'user'])->where('payment_status', 'dibayar');

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('transaction_date', [$start, $end]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('transaction_date', $request->year);
        }

        // ==============================
        // Hitung Total Penjualan (Omzet)
        // ==============================
        $totalPenjualan = (clone $query)->sum('grand_price');

        // ==============================
        // Hitung Total Modal
        // ==============================
        $totalModal = SaleDetail::join('products', 'sale_details.product_id', '=', 'products.id')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->when($request->filled('start_date') && $request->filled('end_date'), function ($q) use ($request) {
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end = Carbon::parse($request->end_date)->endOfDay();
                $q->whereBetween('sales.transaction_date', [$start, $end]);
            })
            ->when($request->filled('month'), function ($q) use ($request) {
                $q->whereMonth('sales.transaction_date', $request->month);
            })
            ->when($request->filled('year'), function ($q) use ($request) {
                $q->whereYear('sales.transaction_date', $request->year);
            })
            ->selectRaw('SUM(products.cost_price * sale_details.quantity) as modal')
            ->value('modal');

        // ==============================
        // Hitung Laba (Omzet - Modal)
        // ==============================
        $totalLaba = $totalPenjualan - $totalModal;

        // ==============================
        // Hitung Utang & Piutang
        // ==============================
        $totalUtang = Payable::when($request->filled('year'), fn($q) => $q->whereYear('created_at', $request->year))
            ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', $request->month))
            ->sum('total_amount');

        $totalPiutang = Receivable::when($request->filled('year'), fn($q) => $q->whereYear('created_at', $request->year))
            ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', $request->month))
            ->sum('total_amount');

        // ==============================
        // Ambil data penjualan per bulan
        // ==============================
        $salesChart = (clone $query)
            ->selectRaw('YEAR(transaction_date) as tahun, MONTH(transaction_date) as bulan, SUM(grand_price) as total')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Normalisasi data: semua bulan ada
        $year = $request->year ?? now()->year;
        $labels = [];
        $values = [];

        for ($m = 1; $m <= 12; $m++) {
            $labels[] = Carbon::create()->month($m)->format('F'); // Nama bulan full
            $row = $salesChart->firstWhere('bulan', $m);
            $values[] = $row ? $row->total : 0;
        }

        return view('report.business-overview.print', [
            'totalPenjualan' => $totalPenjualan,
            'totalModal'     => $totalModal,
            'totalLaba'      => $totalLaba,
            'totalUtang'     => $totalUtang,
            'totalPiutang'   => $totalPiutang,
            'labels'         => $labels,
            'values'         => $values,
            'request'        => $request
        ]);

        // Pilihan 2: jika ingin langsung PDF
        /*
    $pdf = PDF::loadView('report.sales.print_pdf', compact('sales'));
    return $pdf->download('laporan-penjualan.pdf');
    */
    }

    // Sales Plan
    public function indexSalesPlan(Request $request)
    {
        $year = $request->input('year', now()->year);

        // Ambil total penjualan per bulan untuk tahun tertentu
        $salesPerMonth = Sales::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as bulan, SUM(grand_price) as total')
            ->whereYear('created_at', $year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Ambil target per bulan, samakan format jadi YYYY-MM
        $targets = SalesTarget::where('month', 'like', $year . '%')
            ->pluck('target_amount', 'month');


        // Hitung prediksi sederhana (rata-rata 3 bulan terakhir + 5%)
        $avgSales = Sales::selectRaw('AVG(grand_price) as avg_sales')
            ->whereYear('created_at', $year)
            ->whereBetween('created_at', [now()->subMonths(3), now()])
            ->value('avg_sales');

        $prediction = round($avgSales * 1.05, 0);

        $promotions = SalesPromotion::whereYear('start_date', $year)
            ->orWhereYear('end_date', $year)
            ->get();

        return view('report.sales-plan.index', [
            'salesPerMonth' => $salesPerMonth,
            'targets'       => $targets,
            'prediction'    => $prediction,
            'selectedYear'  => $year,
            'promotions'    => $promotions,
        ]);
    }

    public function printSalesPlan(Request $request)
    {
        $year = $request->input('year', now()->year);

        // Ambil total penjualan per bulan untuk tahun tertentu
        $salesPerMonth = Sales::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as bulan, SUM(grand_price) as total')
            ->whereYear('created_at', $year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Ambil target per bulan, samakan format jadi YYYY-MM
        $targets = SalesTarget::where('month', 'like', $year . '%')
            ->pluck('target_amount', 'month');

        // Hitung prediksi sederhana (rata-rata 3 bulan terakhir + 5%)
        $avgSales = Sales::selectRaw('AVG(grand_price) as avg_sales')
            ->whereYear('created_at', $year)
            ->whereBetween('created_at', [now()->subMonths(3), now()])
            ->value('avg_sales');

        $prediction = round($avgSales * 1.05, 0);

        $promotions = SalesPromotion::whereYear('start_date', $year)
            ->orWhereYear('end_date', $year)
            ->get();

        return view('report.sales-plan.print', [
            'salesPerMonth' => $salesPerMonth,
            'targets'       => $targets,
            'prediction'    => $prediction,
            'selectedYear'  => $year,
            'promotions'    => $promotions,
        ]);

        // Pilihan 2: jika ingin langsung PDF
        /*
    $pdf = PDF::loadView('report.sales.print_pdf', compact('sales'));
    return $pdf->download('laporan-penjualan.pdf');
    */
    }

    // Best Selling Product
    public function indexBestSellingProducts(Request $request)
    {
        $query = Product::withSum(['saleDetails as total_sold' => function ($q) use ($request) {
            // Filter by rentang tanggal atau per bulan
            $q->whereHas('sale', function ($saleQuery) use ($request) {
                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $saleQuery->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
                } elseif ($request->filled('month')) {
                    $saleQuery->whereMonth('transaction_date', $request->month);
                } else if ($request->filled('year')) {
                    $saleQuery->whereYear('transaction_date', $request->year);
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
                } else if ($request->filled('year')) {
                    $saleQuery->whereYear('transaction_date', $request->year);
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

    // Orders
    public function indexOrders(Request $request)
    {
        $query = Order::with(['sale', 'driver', 'truck', 'workers.user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('sale', function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%$search%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('report.orders.index', compact('orders'));
    }

    public function printOrders(Request $request)
    {
        $query = Order::with(['sale', 'driver', 'truck', 'workers.user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('sale', function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%$search%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        return view('report.orders.print', compact('orders'));
    }

    public function indexEmployees(Request $request)
    {
        $query = Employees::with('user');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        if ($request->has('position') && $request->position != '') {
            $query->where('position', $request->position);
        }

        $employees = $query->paginate(5);

        return view('report.employees.index', compact('employees'));
    }

    public function printEmployees(Request $request)
    {
        $query = Employees::with('user');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        if ($request->has('position') && $request->position != '') {
            $query->where('position', $request->position);
        }

        $employees = $query->get();

        return view('report.employees.print', compact('employees'));
    }

    public function indexCustomers(Request $request)
    {
        $query = Customer::with(['user'])->withCount('sales');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        $customers = $query->paginate(5);

        return view('report.history-customer.index', compact('customers'));
    }

    public function printCustomers(Request $request)
    {
        $query = Customer::with(['user'])->withCount('sales');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        $customers = $query->get();
        return view('report.history-customer.print-customer', compact('customers'));
    }

    public function historyCustomer(Request $request, $id)
    {
        $query = Order::with(['sale', 'driver', 'truck', 'workers.user'])->whereHas('sale', function ($q) use ($id) {
            $q->where('customer_id', $id);
        });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('sale', function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%$search%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
        $customer = Customer::with('user')->findOrFail($id);

        return view('report.history-customer.detail', compact('orders', 'customer'));
    }

    public function printHistoryCustomer(Request $request, $id)
    {
        $query = Order::with(['sale', 'driver', 'truck', 'workers.user'])->whereHas('sale', function ($q) use ($id) {
            $q->where('customer_id', $id);
        });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('sale', function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%$search%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Filter per bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();
        $customer = Customer::with('user')->findOrFail($id);

        return view('report.history-customer.print-history', compact('orders', 'customer'));
    }

    public function indexTrucks(Request $request)
    {
        $query = Truck::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('plate_number', 'like', "%{$request->search}%")
                ->orWhere('type', 'like', "%{$request->search}%");
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $trucks = $query->paginate(10);
        return view('report.trucks.index', compact('trucks'));
    }

    public function printTrucks(Request $request)
    {
        $query = Truck::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('plate_number', 'like', "%{$request->search}%")
                ->orWhere('type', 'like', "%{$request->search}%");
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $trucks = $query->get();
        return view('report.trucks.print', compact('trucks'));
    }
}
