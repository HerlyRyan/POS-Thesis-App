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
            'edit_posts',
            'view_reports',
        ];

        foreach ($permissions as $permName) {
            Permission::firstOrCreate(['name' => $permName]);
        }

        // Buat roles (buat jika belum ada)
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $viewer = Role::firstOrCreate(['name' => 'viewer']);

        // Assign permissions ke role admin
        $admin->syncPermissions($permissions); // semua permission

        // Assign permission ke role editor
        $editor->syncPermissions(['dashboard_access', 'edit_posts']);

        // Assign permission ke role viewer
        $viewer->syncPermissions(['dashboard_access', 'view_reports']);
    }
}
