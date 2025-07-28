<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->input('year', Carbon::now()->year);

        $totalUsers = User::count();
        $totalSales = Sales::where('payment_status', 'dibayar')->whereYear('created_at', $selectedYear)->count();
        $totalProducts = Product::where('stock', '>', 0)->count();

        $monthlySalesRaw = Sales::selectRaw('MONTH(created_at) as month_number, MIN(MONTHNAME(created_at)) as month, SUM(total_price) as total')
            ->whereYear('created_at', $selectedYear)
            ->where('payment_status', 'dibayar')
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get()
            ->map(function ($item) {
                return [$item->month, (int) $item->total];
            });

        $allMonths = collect([
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ]);

        $monthlySales = $allMonths->map(function ($month) use ($monthlySalesRaw) {
            $found = $monthlySalesRaw->firstWhere(0, $month);
            return $found ?: [$month, 0];
        });

        // Ambil semua tahun yang tersedia di database (untuk opsi filter)
        $availableYears = Sales::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $customerLocations = DB::table('customers')
            ->join('users', 'customers.user_id', '=', 'users.id')
            ->select('users.name', 'customers.address', 'customers.latitude', 'customers.longitude')
            ->whereNotNull('customers.latitude')
            ->whereNotNull('customers.longitude')
            ->get();


        $shippingStatusCounts = DB::table('orders')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        // Normalisasi status agar semua ada meski nol
        $allStatuses = ['draft', 'persiapan', 'pengiriman', 'selesai'];

        $shippingStatusChartData = collect($allStatuses)->map(function ($status) use ($shippingStatusCounts) {
            return [
                'status' => ucfirst($status),
                'total' => $shippingStatusCounts[$status] ?? 0
            ];
        });

        return view('dashboard', compact(
            'totalUsers',
            'totalSales',
            'totalProducts',
            'monthlySales',
            'selectedYear',
            'availableYears',
            'customerLocations',
            'shippingStatusChartData'
        ));
    }
}
