<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'      => 'Admin User',
            'email'     => 'admin@admin.com',
            'password'  => Hash::make('password')
        ]);

        $user->assignRole('user','admin');

        $user2 = User::create([
            'name'      => 'Super Admin User',
            'email'     => 'superadmin@admin.com',
            'password'  => Hash::make('password')
        ]);

        $user2->assignRole('user', 'admin', 'super-admin');
    }
}
