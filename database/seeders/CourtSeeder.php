<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourtSeeder extends Seeder
{
    public function run(): void
    {
        // MENCARI AKUN SELLER DEMO
        $seller = User::where('email', 'seller@mytennis.test')
            ->where('role', 'seller')
            ->firstOrFail();

        // DATA LAPANGAN TENIS
        $courts = [
            [
                'name' => 'Olive Tennis Court',
                'venue_name' => 'Olive Tennis Center',
                'city' => 'Palembang',
                'province' => 'Sumatera Selatan',
                'address' => 'Palembang',
                'price_per_hour' => 100000,
                'description' => 'Lapangan tenis outdoor yang nyaman dengan suasana hijau.',
            ],
            [
                'name' => 'Grand Tennis Arena',
                'venue_name' => 'Grand Sports Center',
                'city' => 'Palembang',
                'province' => 'Sumatera Selatan',
                'address' => 'Palembang',
                'price_per_hour' => 150000,
                'description' => 'Lapangan tenis indoor dengan fasilitas yang lengkap.',
            ],
            [
                'name' => 'Palm Tennis Club',
                'venue_name' => 'Palm Sports Club',
                'city' => 'Palembang',
                'province' => 'Sumatera Selatan',
                'address' => 'Palembang',
                'price_per_hour' => 120000,
                'description' => 'Lapangan tenis outdoor dengan suasana yang asri.',
            ],
            [
                'name' => 'Clay Tennis Court',
                'venue_name' => 'Clay Tennis Center',
                'city' => 'Palembang',
                'province' => 'Sumatera Selatan',
                'address' => 'Palembang',
                'price_per_hour' => 130000,
                'description' => 'Lapangan tenis dengan permukaan tanah liat.',
            ],
            [
                'name' => 'Urban Tennis Space',
                'venue_name' => 'Urban Sports Arena',
                'city' => 'Palembang',
                'province' => 'Sumatera Selatan',
                'address' => 'Palembang',
                'price_per_hour' => 175000,
                'description' => 'Lapangan tenis indoor dengan konsep modern dan minimalis.',
            ],
            [
                'name' => 'Sunset Tennis Club',
                'venue_name' => 'Sunset Sports Center',
                'city' => 'Palembang',
                'province' => 'Sumatera Selatan',
                'address' => 'Palembang',
                'price_per_hour' => 140000,
                'description' => 'Lapangan tenis outdoor yang cocok untuk bermain pada sore hari.',
            ],
        ];

        // MENYIMPAN DATA LAPANGAN
        foreach ($courts as $court) {

            Court::withTrashed()->firstOrCreate(
                [
                    'seller_id' => $seller->id,
                    'name' => $court['name'],
                ],
                array_merge($court, [
                    'image' => null,
                    'status' => 'active',
                ])
            );

        }
    }
}
