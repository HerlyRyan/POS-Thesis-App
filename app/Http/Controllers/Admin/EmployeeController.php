<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query();
        $columns = Schema::getColumnListing('products');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(5);

        return view('admin.product.index', compact('products', 'columns'));
    }
}
