<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Posts permissions
        Permission::create(['name' => 'view posts']);
        Permission::create(['name' => 'create post']);
        Permission::create(['name' => 'view post']);
        Permission::create(['name' => 'update post']);
        Permission::create(['name' => 'delete post']);
        ///////////////////////////////////////////////




        Role::create(['name' => 'admin']);
        User::find(1)->assignRole('admin')
        ->givePermissionTo(Permission::all());

    }
}
