<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list applications']);
        Permission::create(['name' => 'view applications']);
        Permission::create(['name' => 'create applications']);
        Permission::create(['name' => 'update applications']);
        Permission::create(['name' => 'delete applications']);

        Permission::create(['name' => 'list complaints']);
        Permission::create(['name' => 'view complaints']);
        Permission::create(['name' => 'create complaints']);
        Permission::create(['name' => 'update complaints']);
        Permission::create(['name' => 'delete complaints']);

        Permission::create(['name' => 'list kiosks']);
        Permission::create(['name' => 'view kiosks']);
        Permission::create(['name' => 'create kiosks']);
        Permission::create(['name' => 'update kiosks']);
        Permission::create(['name' => 'delete kiosks']);

        Permission::create(['name' => 'list kioskparticipants']);
        Permission::create(['name' => 'view kioskparticipants']);
        Permission::create(['name' => 'create kioskparticipants']);
        Permission::create(['name' => 'update kioskparticipants']);
        Permission::create(['name' => 'delete kioskparticipants']);

        Permission::create(['name' => 'list payments']);
        Permission::create(['name' => 'view payments']);
        Permission::create(['name' => 'create payments']);
        Permission::create(['name' => 'update payments']);
        Permission::create(['name' => 'delete payments']);

        Permission::create(['name' => 'list promotions']);
        Permission::create(['name' => 'view promotions']);
        Permission::create(['name' => 'create promotions']);
        Permission::create(['name' => 'update promotions']);
        Permission::create(['name' => 'delete promotions']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
