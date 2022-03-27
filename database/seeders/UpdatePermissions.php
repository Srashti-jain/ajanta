<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdatePermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::whereIn('id',[1,3,5])->get();

        $permissions = ['mediamanager.manage','chat.manage','sizechart.manage'];

        foreach($permissions as $per){

            Permission::updateorCreate(['name' => $per],[
                'name' => $per
            ]);

        }

        $roles->each(function($role) use ($permissions) {

            if($role->name == 'Super Admin'){
                //all
                $role->givePermissionTo($permissions);
            }

            if($role->name == 'Seller'){
                //permission 01 / 02
                $role->givePermissionTo([$permissions[1],$permissions[2]]);
            }

            if($role->name == 'Support'){
                //permission 00 / 01
                $role->givePermissionTo([$permissions[0],$permissions[1]]);
            }

        });

    }
}
