<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\RedirectResponse;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Employees::with('user');
        $columns = Schema::getColumnListing('employee');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        if ($request->has('position') && $request->position != '') {
            $query->where('position', $request->position);
        }

        $employees = $query->paginate(10);

        return view('admin.employees.index', compact('employees', 'columns'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string',
            'position' => 'required|in:buruh,supir',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('12345678'), // Default password
        ]);

        // Assign employee role
        $user->assignRole('employee');

        // Create employee record
        Employees::create([
            'user_id' => $user->id,
            'position' => $request->position,
            'phone' => $request->phone,
            'status' => 'tersedia', // Default status
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Data karyawan berhasil ditambahkan');
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
        ]);

        //get employee by ID
        $employee = Employees::findOrFail($id);

        // get user by employee->user_id
        $user = User::findOrFail($employee->user_id);

        //update employee without image
        $employee->update([
            'position' => $request->position,
            'phone' => $request->phone,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        //redirect to index
        return redirect()->route('admin.employees.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function show(string $id)
    {
        $employee = Employees::findOrFail($id);

        //render view with employee
        return view('admin.employees.show', compact('employee'));
    }
}
