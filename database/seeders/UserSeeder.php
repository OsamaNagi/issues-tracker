<?php

namespace Database\Seeders;

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
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $developer = User::create([
            'name' => 'Developer User',
            'email' => 'developer@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $client = User::create([
            'name' => 'Client User',
            'email' => 'client@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $admin->roles()->attach(Role::where('name', 'admin')->first());
        $manager->roles()->attach(Role::where('name', 'manager')->first());
        $developer->roles()->attach(Role::where('name', 'developer')->first());
        $client->roles()->attach(Role::where('name', 'client')->first());
    }
}
