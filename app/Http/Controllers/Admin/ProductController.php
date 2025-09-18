<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
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

        $products = $query->orderByDesc('name')->paginate(5);

        return view('admin.product.index', compact('products', 'columns'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|in:galam,bambu,atap',
            'price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'stock' => 'required|integer',
            'unit' => 'required|string',
            'image' => 'required|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        Product::create([
            'image' => $image->hashName(),
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'cost_price' => $request->cost_price,
            'stock' => $request->stock,
            'unit' => $request->unit
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
    }

    public function show(string $id)
    {
        //get product by ID
        $product = Product::findOrFail($id);

        //render view with product
        return view('admin.product.show', compact('product'));
    }

    public function edit(string $id)
    {
        //get product by ID
        $product = Product::findOrFail($id);

        //render view with product
        return view('admin.product.edit', compact('product'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $request->validate([
            'name' => 'string',
            'description' => 'string',
            'category' => 'in:galam,bambu,atap',
            'price' => 'numeric',
            'cost_price' => 'numeric',
            'stock' => 'integer',
            'unit' => 'string',
            'image' => 'mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
        ]);

        //get product by ID
        $product = Product::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            //delete old image
            Storage::delete('public/products/' . $product->image);

            //update product with new image
            $product->update([
                'image' => $image->hashName(),
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price,
                'cost_price' => $request->cost_price,
                'stock' => $request->stock,
                'unit' => $request->unit
            ]);
        } else {

            //update product without image
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price,
                'cost_price' => $request->cost_price,
                'stock' => $request->stock,
                'unit' => $request->unit
            ]);
        }

        //redirect to index
        return redirect()->route('admin.product.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    public function destroy($id): RedirectResponse
    {
        //get product by ID
        $product = Product::findOrFail($id);

        //delete image
        Storage::delete('public/products/' . $product->image);

        //delete product
        $product->delete();

        //redirect to index
        return redirect()->route('admin.product.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function update_stock_view()
    {
        $products = Product::orderBy('stock', 'asc')->get();
        return view('admin.product.increase-stock', compact('products'));
    }

    public function update_stock(Request $request): RedirectResponse
    {
        //get product by ID
        $product = Product::findOrFail($request->productId);

        $product->increment('stock', $request->stock);

        return redirect()->route('admin.product.index')->with(['success' => 'Stock berhasil ditambah!']);
    }
}
