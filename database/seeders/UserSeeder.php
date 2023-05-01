<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\settings;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'manage-permission', 'create-permission', 'edit-permission', 'delete-permission',
            'manage-role', 'create-role', 'edit-role', 'delete-role',
            'manage-user', 'create-user', 'edit-user', 'delete-user',
            'manage-module', 'create-module', 'edit-module', 'delete-module',
            'manage-setting',
            'manage-form', 'create-form', 'edit-form', 'delete-form',
            'design-form',
            'fill-form',
            'duplicate-form',
            'show-submitted-form',
            'manage-submitted-form',
            'edit-submitted-form',
            'delete-submitted-form',
            'download-submitted-form',
            'create-language',
            'manage-language',
            'manage-chat',
        ];


        $modules = [
            'module', 'role', 'user', 'permission', 'setting', 'form','submitted-form','language','chat',
        ];

        $settings = [
            ['key' => 'app_name', 'value' => 'Prime Laravel Form Builder'],
            ['key' => 'app_logo', 'value' => 'uploads/appLogo/app-logo.png'],
            ['key' => 'app_small_logo', 'value' => 'uploads/appLogo/app-small-logo.png'],
            ['key' => 'favicon_logo', 'value' => 'uploads/appLogo/app-favicon-logo.png'],
            ['key' => 'default_language', 'value' => 'en'],
            ['key' => 'color', 'value' => 'theme-1'],
            ['key' => 'app_dark_logo', 'value' => 'uploads/appLogo/app-dark-logo.png'],
            ['key' => 'settingtype', 'value' => 'local'],



        ];
        foreach($settings as $setting){
            settings::create($setting);
        }

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        $role = Role::create([
            'name' => 'Admin'
        ]);


        foreach ($permissions as $permission) {
            $per = Permission::findByName($permission);
            $role->givePermissionTo($per);
        }

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'avatar' => ('avatar.png'),
            'type' => 'Admin',
            'lang' => 'en',
        ]);

        $user->assignRole($role->id);

        Role::create([
            'name' => 'User'
        ]);

        foreach ($modules as $module) {
            Module::create([
                'name' => $module
            ]);
        }
    }
}
