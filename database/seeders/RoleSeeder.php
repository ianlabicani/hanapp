<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin'],
            ['name' => 'owner'],
            ['name' => 'pending_owner'],
            ['name' => 'user'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}
