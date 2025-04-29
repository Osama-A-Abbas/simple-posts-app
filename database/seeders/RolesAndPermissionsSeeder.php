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
        // User::find(1)->assignRole('writer');

        Role::create(['name' => 'writer']);
        //writer permissions
        Permission::create(['name' => 'create post'])->assignRole('writer');
        Permission::create(['name' => 'edit own post'])->assignRole('writer');
        Permission::create(['name' => 'delete own post'])->assignRole('writer');
        Permission::create(['name' => 'like post'])->assignRole('writer');
        Permission::create(['name' => 'write comment'])->assignRole('writer');
        Permission::create(['name' => 'edit on comment'])->assignRole('writer');
        Permission::create(['name' => 'delete on comment'])->assignRole('writer');
        Permission::create(['name' => 'like comment'])->assignRole('writer');
        /////////////////////////////////////////

        Permission::create(['name' => 'view posts']);


        /////////admin
        Permission::create(['name' => 'edit all posts']);
        Permission::create(['name' => 'delete all post']);
        Permission::create(['name' => 'edit all comment']);
        Permission::create(['name' => 'delete all comment']);
        ///////////////////////////////////////////////
        Role::create(['name' => 'admin']);
        User::find(1)->assignRole('admin')
        ->givePermissionTo(Permission::all());
    }
}
