<?php

namespace Cms\Modules\Core\Database\Seeds;

use Cms\Modules\Core\Models\Permission;
use Cms\Modules\Core\Models\Role;
use Cms\Modules\Core\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SampleAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Administrator'
            ],
            [
                'name' => 'user',
                'display_name' => 'Normal user',
                'description' => 'Normal user'
            ],
        ];

        $permissions = [
            [
                'name' => 'create-user',
                'display_name' => 'Create user',
                'description' => 'Can create new user'
            ]
        ];

        $users = [
            [
                'name' => 'CMS Administrator',
                'email' => 'admin@caerux.cms',
                'password' => bcrypt('00000000'),
                'email_verified_at' => Carbon::now()->timestamp
            ],
            [
                'name' => 'CMS Normal User',
                'email' => 'user@caerux.cms',
                'password' => bcrypt('00000000'),
                'email_verified_at' => Carbon::now()->timestamp
            ],
        ];

        foreach ($roles as $k => $role) {
            $newRole = Role::create($role);

            if (array_key_exists($k, $permissions)) {
                $newPermission = Permission::create($permissions[$k]);
                $newRole->attachPermission($newPermission);
            }

            if (array_key_exists($k, $users)) {
                $newUser = User::create($users[$k]);
                $newUser->attachRole($newRole);
            }
        }
    }
}
