<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $developer = User::create([
            'name' => 'Developer',
            'email' => 'developer@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $viewer = User::create([
            'name' => 'Viewer',
            'email' => 'Viewer@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $admin->roles()->attach(Role::where('name', UserRoleEnum::ADMIN)->first());
        $manager->roles()->attach(Role::where('name', UserRoleEnum::MANAGER)->first());
        $developer->roles()->attach(Role::where('name', UserRoleEnum::DEVELOPER)->first());
        $viewer->roles()->attach(Role::where('name', UserRoleEnum::VIEWER)->first());
    }
}
