<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ECommerceController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        $products = $query->paginate(10);

        return view('welcome', compact('products'));
    }

    public function cart(Request $request)
    {        
        return view('customer.cart');
    }
}
