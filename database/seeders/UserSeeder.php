<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
        ]);

        $owner = User::create([
            'name' => 'Owner',
            'email' => 'owner@mail.com',
            'password' => Hash::make('password'),
        ]);

        $admin->roles()->attach(Role::where('name', 'admin')->first());
        $owner->roles()->attach(Role::where('name', 'owner')->first());
    }
}
