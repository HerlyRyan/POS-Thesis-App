<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receivable;
use App\Models\Sales;
use App\Models\Customer;
use Illuminate\Http\Request;

class ReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
        $receivables = $query->paginate(10);
        return view('admin.receivable.index', compact('receivables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sales = Sales::all();
        $customers = Customer::all();
        return view('admin.receivable.create', compact('sales', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'customer_id' => 'required|exists:customers,id',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'remaining_amount' => 'required|numeric|min:0',
            'status' => 'required|string',
            'due_date' => 'required|date',
        ]);

        Receivable::create($request->all());
        return redirect()->route('receivable.index')->with('success', 'Receivable created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $receivable = Receivable::with(['sale', 'customer'])->findOrFail($id);
        return view('admin.receivable.show', compact('receivable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $receivable = Receivable::findOrFail($id);
        $sales = Sales::all();
        $customers = Customer::all();
        return view('admin.receivable.edit', compact('receivable', 'sales', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'customer_id' => 'required|exists:customers,id',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'remaining_amount' => 'required|numeric|min:0',
            'status' => 'required|string',
            'due_date' => 'required|date',
        ]);

        $receivable = Receivable::findOrFail($id);
        $receivable->update($request->all());
        return redirect()->route('receivable.index')->with('success', 'Receivable updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $receivable = Receivable::findOrFail($id);
        $receivable->delete();
        return redirect()->route('receivable.index')->with('success', 'Receivable deleted successfully.');
    }
}
