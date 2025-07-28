<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'admin',
        //     'username' => 'Admin',
        //     'password' => Hash::make('admin123'),
        // ]);

        $users = [
            [
                'name' => 'admin',
                'username' => 'Admin',
                'password' => Hash::make('admin123'),
            ],
            [
                'name' => 'Pimpinan',
                'username' => 'pimpinan',
                'password' => Hash::make('pimpinan123'),
            ],
            [
                'name' => 'Jane Smith',
                'username' => 'jane_smith',
                'password' => Hash::make('password456'),
            ],
            [
                'name' => 'Bob Johnson',
                'username' => 'bob_johnson',
                'password' => Hash::make('password789'),
            ],
            [
                'name' => 'Alice Brown',
                'username' => 'alice_brown',
                'password' => Hash::make('password321'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
