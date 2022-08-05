<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'User Access',
            'key' => \Str::slug('User Access')
        ]);
        Permission::create([
            'name' => 'User Edit',
            'key' => \Str::slug('User Edit')
        ]);
        Permission::create([
            'name' => 'Roles Access',
            'key' => \Str::slug('Roles Access')
        ]);
        Permission::create([
            'name' => 'Roles Edit',
            'key' => \Str::slug('Roles Edit')
        ]);
        Permission::create([
            'name' => 'Roles Create',
            'key' => \Str::slug('Roles Create')
        ]);
        Permission::create([
            'name' => 'User Access',
            'key' => \Str::slug('User Access')
        ]);
        Permission::create([
            'name' => 'Permission Create',
            'key' => \Str::slug('Permission Create')
        ]);
        Permission::create([
            'name' => 'Permission Edit',
            'key' => \Str::slug('Permission Edit')
        ]);
    }
}
