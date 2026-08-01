<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super-admin@mail.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $superAdmin->syncRoles(Role::findOrCreate('super-admin'));

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->syncRoles(Role::findOrCreate('admin'));

        $member = User::create([
            'name' => 'Staff',
            'email' => 'staff@mail.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $member->assignRole(Role::findOrCreate('staff'));
    }
}
