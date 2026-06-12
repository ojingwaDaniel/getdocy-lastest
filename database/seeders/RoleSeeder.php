<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
     
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

       
        $permissions = [
            'manage-users',
            'manage-departments',
            'manage-courses',
            'upload-documents',
            'download-documents',
            'view-documents',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

   
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $lecturer = Role::firstOrCreate(['name' => 'lecturer']);
        $lecturer->givePermissionTo(['upload-documents', 'view-documents', 'download-documents']);

        $student = Role::firstOrCreate(['name' => 'student']);
        $student->givePermissionTo(['view-documents', 'download-documents']);
    }
}