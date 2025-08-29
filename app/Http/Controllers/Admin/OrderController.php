<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use App\Models\Order;
use App\Models\Truck;
use App\Models\TruckTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['sale', 'driver', 'truck', 'workers.user']);

        $user = Auth::user();
        
        if ($user->roles->first()?->name === 'employee') {
            $employeeId = $user->id;            

            $query->where(function ($q) use ($employeeId) {
                $q->where('driver_id', $employeeId)
                    ->orWhereHas('workers', function ($q2) use ($employeeId) {
                        $q2->where('employees.id', $employeeId);
                    });
            });
        }

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

        TruckTracking::create([
            'truck_id' => $truck->id,
            'latitude' => -3.4868733,
            'longitude' => 114.7087524,
            19,
            'status' => 'jalan',
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Supir dan truk berhasil ditetapkan.');
    }

    public function markAsCompleted(Order $order)
    {
        if ($order->status !== 'pengiriman') {
            return redirect()->back()->withErrors(['msg' => 'Order belum dalam status pengiriman.']);
        }

        DB::transaction(function () use ($order) {
            // Update status order
            $order->update(['status' => 'selesai']);

            // Update status truk dan supir
            if ($order->truck) {
                $order->truck->update(['status' => 'tersedia']);
            }

            if ($order->driver) {
                $order->driver->update(['status' => 'tersedia']);
            }

            TruckTracking::where('truck_id', $order->truck->id)->delete();
        });

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil diselesaikan.');
    }
}
