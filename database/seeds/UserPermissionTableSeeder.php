<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-show-details',
            'user-profile-update',
            'budget-list',
            'budget-show-details',
        ];

        foreach ($permissions as $permission)
        {
            $obj_permission = Permission::where('name', $permission)->first();
            if (is_null($obj_permission)) Permission::create(['name' => $permission]);
        }

        $role = Role::where('name', 'User')->first();

        if (is_null($role))
        {
            $role = new Role();
            $role->name = 'User';
            $role->save();
        }

        if (!is_null($role))
        {
            $permissionTemp = [];

            foreach ($permissions as $permission)
            {
                $temp = Permission::where('name', $permission)->first();
                $permissionTemp[] = $temp->id;
            }

            $role->syncPermissions($permissionTemp);
        }
    }
}
