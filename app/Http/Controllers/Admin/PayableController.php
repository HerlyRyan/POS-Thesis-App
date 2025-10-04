<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payable; // Assuming the model is App\Models\Payable
use Illuminate\Http\Request;

class PayableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payable::latest();
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('lender_name', 'LIKE', "%{$search}%");
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        $payables = $query->paginate(10);
        return view('admin.payable.index', compact('payables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payable.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lender_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_amount' => 'required|numeric|min:0',
            'installment_amount' => 'required|numeric|min:0',
            'remaining_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:paid,unpaid,partial', // Adjust status options as needed
            'due_date' => 'required|date',
        ]);

        Payable::create($request->all());

        return redirect()->route('admin.payable.index')
                         ->with('success', 'Payable created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payable $payable)
    {
        return view('admin.payable.show', compact('payable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payable $payable)
    {
        return view('admin.payable.edit', compact('payable'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payable $payable)
    {
        $request->validate([
            'lender_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_amount' => 'required|numeric|min:0',
            'installment_amount' => 'required|numeric|min:0',
            'remaining_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:paid,unpaid,partial', // Adjust status options as needed
            'due_date' => 'required|date',
        ]);

        $payable->update($request->all());

        return redirect()->route('admin.payable.index')
                         ->with('success', 'Payable updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payable $payable)
    {
        $payable->delete();

        return redirect()->route('admin.payable.index')
                         ->with('success', 'Payable deleted successfully.');
    }
}
