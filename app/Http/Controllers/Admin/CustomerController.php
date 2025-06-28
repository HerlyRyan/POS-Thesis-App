<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SaleDetail;
use App\Models\Sales;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $query = Customer::query(); // Add relationship loading
        $columns = Schema::getColumnListing('customers');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', "%{$request->search}%");            
        }        


        $customers = $query->paginate(5);

        return view('admin.customers.index', compact('customers', 'columns'));
    }        

    public function show(string $id)
    {
        //get product by ID
        $customer = Customer::findOrFail($id);

        //render view with cus$customer
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);

        //render view with customer
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $request->validate([
            'name' => 'string',
            'email' => 'string',
            'phone' => 'string',
            'address' => 'string',
        ]);

        //get customer by ID
        $customer = Customer::findOrFail($id);

        //update customer without image
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        //redirect to index
        return redirect()->route('admin.customers.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    
}
