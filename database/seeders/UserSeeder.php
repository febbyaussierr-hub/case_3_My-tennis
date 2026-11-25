<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // AKUN SELLER
        User::firstOrCreate(
            [
                'email' => 'seller@mytennis.test',
            ],
            [
                'name' => 'My Tennis Seller',
                'password' => Hash::make('seller123'),
                'role' => 'seller',
                'phone' => '081234567801',
                'date_of_birth' => '2000-01-01',
            ]
        );

        // AKUN BUYER
        User::firstOrCreate(
            [
                'email' => 'buyer@mytennis.test',
            ],
            [
                'name' => 'My Tennis Buyer',
                'password' => Hash::make('buyer123'),
                'role' => 'buyer',
                'phone' => '081234567802',
                'date_of_birth' => '2004-01-01',
            ]
        );
    }
}
