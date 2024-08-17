<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Define the permissions
        $permissions = [
            'manage users',
            'edit articles',
            'publish articles',
            'delete articles',
            'view orders',
            'manage orders',
        ];

        // Create and assign the permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Administrator role - has all permissions
        $admin = Role::create(['name' => 'Administrator']);
        $admin->givePermissionTo(Permission::all());

        // Author role - can edit and publish articles
        $author = Role::create(['name' => 'Author']);
        $author->givePermissionTo(['edit articles', 'publish articles']);

        // Customer role - no special permissions, can be used for frontend user control
        Role::create(['name' => 'Customer']);

        // Operator role - can view and manage orders
        $operator = Role::create(['name' => 'Operator']);
        $operator->givePermissionTo(['view orders', 'manage orders']);
    }
}
