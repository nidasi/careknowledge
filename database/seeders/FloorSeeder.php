<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Floor;

class FloorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $floors = [
            '1階',
            '2階',
            '3階',
        ];

        foreach ($floors as $floor) {
            Floor::create([
                'floor_name' => $floor,
            ]);
        }
    }
}
