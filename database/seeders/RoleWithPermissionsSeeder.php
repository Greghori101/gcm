<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleWithPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolePermissions = config('permission.role_permissions');

        foreach ($rolePermissions as $roleName => $models) {
            // Create or get the role
            $role = Role::firstOrCreate(['name' => $roleName]);

            $permissions = [];
            foreach ($models as $model => $actions) {
                foreach ($actions as $action) {
                    $permissionName = $action . ' ' . strtolower($model);
                    // Create or get the permission
                    $permission = Permission::firstOrCreate(['name' => $permissionName]);
                    $permissions[] = $permission;
                }
            }
            // Assign all permissions to the role
            $role->syncPermissions($permissions);
        }
    }
}
