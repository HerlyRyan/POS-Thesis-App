<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesTarget;
use Illuminate\Http\Request;

class SalesTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SalesTarget::query();

        // Filter per tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }
        $salesTargets = $query->orderBy('month', 'desc')->paginate(12);

        return view('admin.sales-targets.index', compact('salesTargets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sales-targets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
            'target_amount' => 'required|numeric|min:0',
        ]);

        SalesTarget::create($request->only(['month', 'target_amount']));

        return redirect()->route('admin.sales-targets.index')
            ->with('success', 'Sales target created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $salesTarget = SalesTarget::findOrFail($id);
        return view('admin.sales-targets.show', compact('salesTarget'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $salesTarget = SalesTarget::findOrFail($id);
        return view('admin.sales-targets.edit', compact('salesTarget'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
            'target_amount' => 'required|numeric|min:0',
        ]);

        $salesTarget = SalesTarget::findOrFail($id);
        $salesTarget->update($request->only(['month', 'target_amount']));

        return redirect()->route('admin.sales-targets.index')
            ->with('success', 'Sales target updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $salesTarget = SalesTarget::findOrFail($id);
        $salesTarget->delete();

        return redirect()->route('admin.sales-targets.index')
            ->with('success', 'Sales target deleted successfully.');
    }
}
