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

        // Permission::create(['name' => 'view books']); //user



        // Role::create(['name' => 'admin']);
        // User::find(1)->assignRole('admin')
        // ->givePermissionTo(Permission::all());

    }
}
