<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['sale', 'driver', 'truck']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('sale', function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
            'driver_id' => 'nullable|exists:users,id',
            'truck_id' => 'nullable|exists:trucks,id',
        ]);

        $order->update($request->only(['status', 'driver_id', 'truck_id']));

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    public function assignWorker(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
            'driver_id' => 'nullable|exists:users,id',
            'truck_id' => 'nullable|exists:trucks,id',
        ]);

        $order->update($request->only(['status', 'driver_id', 'truck_id']));

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }
}
