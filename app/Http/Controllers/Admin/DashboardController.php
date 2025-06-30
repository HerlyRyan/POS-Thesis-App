<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalSales = Sales::where('payment_status', 'dibayar')->count();
        $totalProducts = Product::where('stock', '>', 0)->count();

        return view('admin.dashboard', compact('totalUsers', 'totalSales', 'totalProducts'));
    }
}
