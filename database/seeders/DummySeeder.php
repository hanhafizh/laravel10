<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     for ($i = 1005; $i < 10000; $i++) {
    //         User::create(
    //             [
    //                 'name' => 'User' . $i,
    //                 'email' => 'user' . $i . '@gmail.com',
    //                 'password' => Hash::make('user')
    //             ]

    //         );
    //     }
    // }

    public function run(): void
    {
        // Hapus semua data kecuali 3 data pertama
        User::whereNotIn('id', [1, 2, 3])->delete();

        // Tambahkan 3 data dummy jika diperlukan
        $users = [
            [
                'name' => 'User1',
                'email' => 'user1@gmail.com',
                'password' => Hash::make('user')
            ],
            [
                'name' => 'User2',
                'email' => 'user2@gmail.com',
                'password' => Hash::make('user')
            ],
            [
                'name' => 'User3',
                'email' => 'user3@gmail.com',
                'password' => Hash::make('user')
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
