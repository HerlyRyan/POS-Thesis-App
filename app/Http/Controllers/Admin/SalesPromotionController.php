<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesPromotion;
use Illuminate\Http\Request;

class SalesPromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = SalesPromotion::orderBy('start_date', 'desc')->paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.promotions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'expected_increase' => 'nullable|numeric'
        ]);

        SalesPromotion::create($request->all());
        return redirect()->route('admin.promotions.index')->with('success', 'Promo berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesPromotion $promotion)
    {
        return view('admin.promotions.show', compact('promotion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesPromotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesPromotion $promotion)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'expected_increase' => 'nullable|numeric'
        ]);

        $promotion->update($request->all());
        return redirect()->route('admin.promotions.index')->with('success', 'Promo berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesPromotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('admin.promotions.index')->with('success', 'Promo berhasil dihapus');
    }
}
