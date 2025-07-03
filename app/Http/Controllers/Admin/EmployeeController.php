<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\RedirectResponse;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Employees::with('user');
        $columns = Schema::getColumnListing('employee');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->has('position') && $request->position != '') {
            $query->where('position', $request->position);
        }

        $employees = $query->paginate(5);

        return view('admin.employees.index', compact('employees', 'columns'));
    }

    public function edit(string $id)
    {
        $employee = Employees::findOrFail($id);

        //render view with employee
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $request->validate([            
            'position' => 'string',
            'phone' => 'string',
            'hourly_rate' => 'numeric',
        ]);

        //get employee by ID
        $employee = Employees::findOrFail($id);

        //update employee without image
        $employee->update([            
            'position' => $request->position,
            'phone' => $request->phone,
            'hourly_rate' => $request->hourly_rate,
        ]);

        //redirect to index
        return redirect()->route('admin.employees.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
}
