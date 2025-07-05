<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $query = Customer::with('user'); // Add relationship loading
        $columns = Schema::getColumnListing('customers');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', "%{$request->search}%");
        }


        $customers = $query->paginate(5);

        return view('admin.customers.index', compact('customers', 'columns'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('12345678'),
        ]);

        // Assign role berdasarkan nama
        $user->assignRole('customer');

        Customer::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Data berhasil ditambahkan');
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
            'email' => 'string|email',
            'phone' => 'string',
            'address' => 'string',
        ]);

        //get customer by ID
        $customer = Customer::findOrFail($id);

        // get user by customer->user_id
        $user = User::findOrFail($customer->user_id);        

        //update customer without image
        $customer->update([
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        //redirect to index
        return redirect()->route('admin.customers.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
}
