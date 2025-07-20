<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use App\Models\Order;
use App\Models\Truck;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['sale', 'driver', 'truck', 'workers.user']);

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

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
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

    public function assignWorkerView(Order $order)
    {
        $availableWorkers = Employees::where('position', 'buruh')->where('status', 'tersedia')->get();
        return view('admin.orders.assign-worker', compact('order', 'availableWorkers'));
    }

    public function assignWorker(Request $request, Order $order)
    {
        $request->validate([
            'shipping_date' => 'required|date',
            'worker_ids' => 'required|array',
            'worker_ids.*' => 'exists:employees,id',
        ]);

        // Simpan ke pivot table
        $order->workers()->sync($request->worker_ids);

        // Update status semua pekerja jadi bekerja
        Employees::whereIn('id', $request->worker_ids)->update(['status' => 'bekerja']);

        // Update status order jadi persiapan
        $order->update(['shipping_date' => $request->shipping_date, 'status' => 'persiapan']);

        return redirect()->route('admin.orders.index')->with('success', 'Pekerja berhasil diassign.');
    }


    // Tampilkan form
    public function assignDeliveryForm(Order $order)
    {
        $drivers = Employees::where('position', 'supir')->where('status', 'tersedia')->get();
        $trucks = Truck::where('status', 'tersedia')->get();

        return view('admin.orders.assign-delivery', compact('order', 'drivers', 'trucks'));
    }

    // Simpan assign supir + truk
    public function assignDelivery(Request $request, Order $order)
    {
        $request->validate([
            'driver_id' => 'required|exists:employees,id',
            'truck_id' => 'required|exists:trucks,id',
        ]);

        $driver = Employees::findOrFail($request->driver_id);
        $truck = Truck::findOrFail($request->truck_id);

        // Update Order
        $order->update([
            'driver_id' => $driver->id,
            'truck_id' => $truck->id,
            'status' => 'pengiriman',
        ]);

        // Update status semua pekerja (buruh) yang terkait
        if ($order->workers && $order->workers->count() > 0) {
            $workerIds = $order->workers->pluck('id')->toArray();
            Employees::whereIn('id', $workerIds)->update(['status' => 'tersedia']);
        }

        // Update status supir dan truk     
        $driver->update(['status' => 'bekerja']);
        $truck->update(['status' => 'dipakai']);

        return redirect()->route('admin.orders.index')->with('success', 'Supir dan truk berhasil ditetapkan.');
    }

    public function markAsCompleted(Order $order)
    {
        if ($order->status !== 'pengiriman') {
            return redirect()->back()->withErrors(['msg' => 'Order belum dalam status pengiriman.']);
        }

        // Update status order
        $order->update(['status' => 'selesai']);

        // Update status truck jadi tersedia
        if ($order->truck) {
            $order->truck->update(['status' => 'tersedia']);
        }

        // Update status driver (employee supir) jadi tersedia
        if ($order->driver) {
            $order->driver->update(['status' => 'tersedia']);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil diselesaikan.');
    }
}
