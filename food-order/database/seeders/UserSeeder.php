<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password123');

        User::updateOrCreate(
            ['email' => 'admin@food.com'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'role' => 'admin',
                'password' => $password,
                'no_telp' => '081111111111',
                'alamat' => 'Kantor Admin Food Order',
            ]
        );

        User::updateOrCreate(
            ['email' => 'resto1@food.com'],
            [
                'name' => 'Resto 1',
                'username' => 'resto1',
                'role' => 'restoran',
                'password' => $password,
                'no_telp' => '081222222221',
                'alamat' => 'Jl. Kuliner No. 1',
            ]
        );

        User::updateOrCreate(
            ['email' => 'resto2@food.com'],
            [
                'name' => 'Resto 2',
                'username' => 'resto2',
                'role' => 'restoran',
                'password' => $password,
                'no_telp' => '081222222222',
                'alamat' => 'Jl. Kuliner No. 2',
            ]
        );

        for ($i = 1; $i <= 3; $i++) {
            User::updateOrCreate(
                ['email' => "pelanggan{$i}@food.com"],
                [
                    'name' => "Pelanggan {$i}",
                    'username' => "pelanggan{$i}",
                    'role' => 'pelanggan',
                    'password' => $password,
                    'no_telp' => '08133333333' . $i,
                    'alamat' => "Jl. Pelanggan No. {$i}",
                ]
            );
        }
    }
}
