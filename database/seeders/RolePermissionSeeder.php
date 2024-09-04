<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' =>'create-lagu']);
        Permission::create(['name' =>'read-lagu']);
        Permission::create(['name' =>'update-lagu']);
        Permission::create(['name' =>'delete-lagu']);

        Permission::create(['name' =>'create-playlist']);
        Permission::create(['name' =>'read-playlist']);
        Permission::create(['name' =>'update-playlist']);
        Permission::create(['name' =>'delete-playlist']);

        Role::create(['name'=>'publisher']);
        Role::create(['name'=>'public']);

        $rolePublisher = Role::findByName('publisher');
        $rolePublisher->givePermissionTo(('create-lagu'));
        $rolePublisher->givePermissionTo(('read-lagu'));
        $rolePublisher->givePermissionTo(('update-lagu'));
        $rolePublisher->givePermissionTo(('delete-lagu'));

        $rolePublic = Role::findByName('public');
        $rolePublic->givePermissionTo(('create-playlist'));
        $rolePublic->givePermissionTo(('read-playlist'));
        $rolePublic->givePermissionTo(('update-playlist'));
        $rolePublic->givePermissionTo(('delete-playlist'));
        $rolePublic->givePermissionTo(('read-lagu'));
    }
}
