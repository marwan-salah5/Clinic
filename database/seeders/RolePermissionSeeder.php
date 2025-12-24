<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view-dashboard',
            'manage-patients',
            'manage-appointments',
            'manage-medical-history',
            'manage-doctors',
            'manage-invoices',
            'manage-follow-ups',
            'manage-users', // Admin only
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Admin role and assign all permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Create Staff role and assign limited permissions
        $staffRole = Role::create(['name' => 'staff']);
        $staffRole->givePermissionTo([
            'view-dashboard',
            'manage-patients',
            'manage-appointments',
            'manage-medical-history',
            'manage-doctors',
            'manage-invoices',
            'manage-follow-ups',
        ]);
    }
}
