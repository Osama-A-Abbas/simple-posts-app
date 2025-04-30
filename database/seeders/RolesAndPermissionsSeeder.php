<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // === Define Roles ===
        $roles = [
            'writer',
            'moderator',
            'admin',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // === Define Permissions ===
        $permissions = [
            // Writer Permissions
            'writer' => [
                'create post', 'edit own post', 'delete own post', 'view posts', 'like post',
                'write comment', 'edit own comment', 'delete own comment', 'like comment',
                'view own profile', 'edit own profile', 'view public profiles', 'delete own account',
            ],

            // Moderator Permissions
            'moderator' => [
                'edit all posts', 'delete all posts', 'edit all comments', 'delete all comments',
            ],

            // Admin Permissions
            'admin' => [
                'view users', 'view user', 'edit user', 'delete user', 'create user',
                'access admin panel', 'manage roles', 'manage permissions',
                'view system logs', 'view private profile',
            ],
        ];

        // === Create and Assign Permissions ===
        foreach ($permissions as $role => $perms) {
            foreach ($perms as $perm) {
                $permission = Permission::firstOrCreate(['name' => $perm]);
                Role::where('name', $role)->first()?->givePermissionTo($permission);
            }
        }

        // Assign all permissions to admin role
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole?->syncPermissions(Permission::all());

        // === Assign Roles to Specific Users ===
        User::find(1)?->assignRole('admin');
        User::find(2)?->assignRole('moderator');
    }
}
