<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'client-list',
            'client-create',
            'client-edit',
            'client-delete',
            'activity-list',
            'activity-create',
            'activity-edit',
            'activity-delete',
            'service-list',
            'service-create',
            'service-edit',
            'service-delete',
            'budget-list',
            'budget-create',
            'budget-edit',
            'budget-delete',
            'os-list',
            'os-create',
            'os-edit',
            'os-delete',
        ];

        foreach ($permissions as $permission) {
            $obj_permission = Permission::where('name', $permission)->first();
            if (is_null($obj_permission)) Permission::create(['name' => $permission]);
        }

        $role = Role::where('name', 'Admin')->first();

        if (!is_null($role))
        {
            $permissions = Permission::pluck('id', 'id')->all();

            $role->syncPermissions($permissions);
        }
    }
}
