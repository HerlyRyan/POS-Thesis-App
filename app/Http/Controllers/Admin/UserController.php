<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employees;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        $roles = Role::all();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->paginate(5)->appends($request->query());

        return view('admin.users.index', compact('users', 'roles'));
    }


    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($request->has('roles')) {
            // Ambil nama role berdasarkan ID
            $roleNames = Role::whereIn('id', $request->roles)->pluck('name')->toArray();

            // Assign role berdasarkan nama
            $user->assignRole($roleNames);

            // Jika ada role 'customer', maka buatkan record Customer
            if (in_array('customer', $roleNames)) {
                $new_cust = Customer::create([
                    'user_id' => $user->id,                    
                ]);

                // Redirect ke edit customer
                return redirect()->route('admin.customers.edit', $new_cust->id)->with('success', 'User created successfully.');
            } else if (in_array('employee', $roleNames)) {
                $new_employee = Employees::create([
                    'user_id' => $user->id,
                    'position' => $request->position ?? 'buruh', // posisi default
                    'hourly_rate' => $request->hourly_rate ?? 0,
                ]);

                // Redirect ke edit employee
                return redirect()->route('admin.employees.edit', $new_employee->id)->with('success', 'User created successfully.');
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }


    public function show(User $user)
    {
        $roles = $user->roles;
        return view('admin.users.show', compact('user', 'roles'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $assignedRoles = $user->roles->pluck('id')->toArray();
        return view('admin.users.edit', compact('user', 'roles', 'assignedRoles'));
    }

    public function update(Request $request, User $user)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id', // Validate role IDs
        ]);

        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Map role IDs to role names
        $roleIds = $request->roles;
        $validRoleNames = Role::whereIn('id', $roleIds)->pluck('name')->toArray();

        // Sync roles by name
        $user->syncRoles($validRoleNames);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
