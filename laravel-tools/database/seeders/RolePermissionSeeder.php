<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $teacher = Role::create(['name' => 'teacher']);
        $student = Role::create(['name' => 'student']);

        // create permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'create course']);
        Permission::create(['name' => 'edit course']);
        Permission::create(['name' => 'view course']);
        Permission::create(['name' => 'view results']);

        // give permissions to roles
        $admin->givePermissionTo(Permission::all()); // admin gets all
        $teacher->givePermissionTo(['create course', 'edit course', 'view course', 'view results']);
        $student->givePermissionTo(['view course', 'view results']);
    }
}
