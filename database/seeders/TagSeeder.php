<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = ['不穏時', '認知症', '食事拒否', '転倒リスク', '夜間対応'];

        foreach ($tags as $name) {
            Tag::create(['tag_name' => $name]);
        }
    }
}
