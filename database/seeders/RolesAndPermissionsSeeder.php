<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cache to avoid permission issues
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // === ROLES ===
        $writerRole = Role::create(['name' => 'writer']);
        $adminRole = Role::create(['name' => 'admin']);
        $moderatorRole = Role::create(['name' => 'moderator']);

        // === PERMISSIONS ===

        // Post Permissions
        $postPermissions = [
            'create post',
            'edit own post',
            'delete own post',
            'view posts',
            'like post',
        ];

        // Comment Permissions
        $commentPermissions = [
            'write comment',
            'edit own comment',
            'delete own comment',
            'like comment',
        ];

        // Admin / Moderator Permissions
        $modPermissions = [
            'edit all posts',
            'delete all posts',
            'edit all comments',
            'delete all comments',
        ];

        // General App Permissions
        $generalPermissions = [
            // User management
            'view users',
            'view user',
            'edit user',
            'delete user',
            'create user',

            // System / Admin
            'access admin panel',
            'manage roles',
            'manage permissions',
            'view system logs',

            // Personal profile
            'view own profile',
            'edit own profile',
        ];

        // Create and assign permissions to writer
        foreach (array_merge($postPermissions, $commentPermissions) as $perm) {
            Permission::create(['name' => $perm])->assignRole($writerRole);
        }

        // Create and assign moderator permissions (if needed)
        foreach ($modPermissions as $perm) {
            Permission::create(['name' => $perm])->assignRole($moderatorRole);
        }

        // Create and assign to admin
        foreach ($generalPermissions as $perm) {
            Permission::create(['name' => $perm])->assignRole($adminRole);
        }

        // Assign all permissions to admin
        $allPermissions = Permission::all();
        User::find(1)?->assignRole($adminRole)->givePermissionTo($allPermissions);

        // Assign mod permissions to user 2
        User::find(2)?->assignRole($moderatorRole);
    }
}
