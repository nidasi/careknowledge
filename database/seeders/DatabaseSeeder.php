<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //ローカル環境だけダミーユーザーを10件作成
        if (app()->environment('local')) {
            User::factory(10)->create();
        }

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        //ResidentとTagのSeeder追加し実行
        $this->call([
            FloorSeeder::class,
            ResidentSeeder::class,
            TagSeeder::class,
        ]);
    }
}
