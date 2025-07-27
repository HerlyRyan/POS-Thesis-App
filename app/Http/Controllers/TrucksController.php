<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\TruckTracking;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class TrucksController extends Controller
{
    /**
     * Display a listing of the trucks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Truck::query();
        $columns = Schema::getColumnListing('trucks');

        if ($request->has('search') && $request->search != '') {
            $query->where('plate_number', 'like', "%{$request->search}%")
                ->orWhere('type', 'like', "%{$request->search}%");
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $trucks = $query->paginate(10);

        return view('admin.trucks.index', compact('trucks', 'columns'));
    }

    /**
     * Show the form for creating a new truck.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.trucks.create');
    }

    /**
     * Store a newly created truck in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plate_number' => 'required|unique:trucks,plate_number',
            'type' => 'required|string',
            'capacity' => 'required|string',
            'status' => 'required|in:tersedia,dipakai,diperbaiki'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Truck::create($request->all());

        return redirect()->route('admin.trucks.index')
            ->with('success', 'Truck created successfully.');
    }

    /**
     * Display the specified truck.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $truck = Truck::findOrFail($id);
        return view('admin.trucks.show', compact('truck'));
    }

    /**
     * Show the form for editing the specified truck.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $truck = Truck::findOrFail($id);
        return view('admin.trucks.edit', compact('truck'));
    }

    /**
     * Update the specified truck in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $truck = Truck::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'plate_number' => 'required|unique:trucks,plate_number,' . $id,
            'type' => 'required|string',
            'capacity' => 'required|string',
            'status' => 'required|in:tersedia,dipakai,diperbaiki'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $truck->update($request->all());

        return redirect()->route('admin.trucks.index')
            ->with('success', 'Truck updated successfully.');
    }

    /**
     * Remove the specified truck from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $truck = Truck::findOrFail($id);
        $truck->delete();

        return redirect()->route('admin.trucks.index')
            ->with('success', 'Truck deleted successfully.');
    }

    public function tracking()
    {
        $trucks = Truck::with(['latestTracking'])->get();
        return view('admin.trucks.tracking', compact('trucks'));
    }

    public function storeTracking(Request $request)
    {
        $validated = $request->validate([
            'truck_id' => 'required|exists:trucks,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        TruckTracking::updateOrCreate(
            ['truck_id' => $validated['truck_id']], // kondisi pencarian
            [ // data yang ingin diupdate atau dibuat
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'status' => 'jalan',
            ]
        );

        return response()->json(['message' => 'Lokasi berhasil diperbarui']);
    }
}
