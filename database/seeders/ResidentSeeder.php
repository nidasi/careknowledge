<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resident;
use App\Models\Floor;
use App\Models\User;

class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $floor = Floor::first();

        Resident::create([
            'user_id' => $user->id,
            'floor_id' => $floor->id,
            'resident_name' => 'テスト タロウ',
            'room_number' => '101',
        ]);
    }
}
