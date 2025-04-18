<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Import Hash facade
use App\Models\User; // Import User model

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'Admin',
                'role' => 'admin',
                'email' => 'admin@gmail.com',
                'username' => 'admin1@gmail.com',
                'password' => bcrypt('password2024'),
            ],
            [
                    'name' => 'oktova',
                    'nim' => '42324001',
                    'prodi' => 'Teknologi Informasi',
                    'tahun_angkatan' => '2024',
                    'role' => 'mahasiswa',
                    'email' => 'oktova@gmail.com',
                    'username' => 'if324001',
                    'password' => bcrypt('oktova'),
            ],
            [
                    'name' => 'aditia',
                    'nim' => '42324038',
                    'prodi' => 'Teknologi Informasi',
                    'tahun_angkatan' => '2024',
                    'role' => 'mahasiswa',
                    'email' => 'adita@gmail.com',
                    'username' => 'if324038',
                    'password' => bcrypt('aditia'),
             ],
             [
                    'name' => 'grace',
                    'nim' => '42324039',
                    'prodi' => 'Teknologi Informasi',
                    'tahun_angkatan' => '2024',
                    'role' => 'mahasiswa',
                    'email' => 'grace@gmail.com',
                    'username' => 'if324040',
                    'password' => bcrypt('grace'),
            ],
            [
                'name' => 'Dosen',
                'role' => 'dosen',
                'email' => 'dosen@gmail.com',
                'username' => 'dosen@gmail.com',
                'password' => bcrypt('dosen123'),
            ]
        ];

        foreach ($userData as $key => $value){
            User::create($value);
        }
    }
}
