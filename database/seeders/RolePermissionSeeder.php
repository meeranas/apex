<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $issuerRole = Role::firstOrCreate(['name' => 'issuer']);

        // Create permissions
        $permissions = [
            // Invoice permissions
            'view_any_invoice',
            'view_invoice',
            'create_invoice',
            'update_invoice',
            'delete_invoice',
            'restore_invoice',
            'force_delete_invoice',

            // Transaction permissions
            'view_any_transaction',
            'view_transaction',
            'create_transaction',
            'update_transaction',
            'delete_transaction',
            'restore_transaction',
            'force_delete_transaction',

            // Customer permissions
            'view_any_customer',
            'view_customer',
            'create_customer',
            'update_customer',
            'delete_customer',
            'restore_customer',
            'force_delete_customer',

            // Issuer permissions
            'view_any_issuer',
            'view_issuer',
            'create_issuer',
            'update_issuer',
            'delete_issuer',
            'restore_issuer',
            'force_delete_issuer',

            // Dashboard permissions
            'view_dashboard',
            'view_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to admin
        $adminRole->syncPermissions(Permission::all());

        // Assign limited permissions to issuer
        $issuerRole->syncPermissions([
            'view_any_invoice',
            'view_invoice',
            'create_invoice',
            'update_invoice',
            'view_any_transaction',
            'view_transaction',
            'create_transaction',
            'update_transaction',
            'view_any_customer',
            'view_customer',
            'view_dashboard',
            'view_reports',
        ]);
    }
}
