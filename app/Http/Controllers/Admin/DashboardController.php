<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalSales = Sales::where('payment_status', 'dibayar')->count();
        $totalProducts = Product::where('stock', '>', 0)->count();

        $monthlySalesRaw = Sales::selectRaw('MONTH(created_at) as month_number, MIN(MONTHNAME(created_at)) as month, SUM(total_price) as total')
            ->whereYear('created_at', Carbon::now()->year)
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

        return view('admin.dashboard', compact('totalUsers', 'totalSales', 'totalProducts', 'monthlySales'));
    }
}
