<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     //
    // }
    public function run()
    {
        // Buat permissions (buat jika belum ada)
        $permissions = [
            'dashboard_access',            
            'view_reports',
        ];

        foreach ($permissions as $permName) {
            Permission::firstOrCreate(['name' => $permName]);
        }

        // Buat roles (buat jika belum ada)
        $admin = Role::firstOrCreate(['name' => 'admin']);     
        $customer = Role::firstOrCreate(['name' => 'customer']);
        $employee = Role::firstOrCreate(['name' => 'employee']);
        $owner = Role::firstOrCreate(['name' => 'owner']);

        // Assign permissions ke role admin
        $admin->syncPermissions($permissions); // semua permission        
    }
}
