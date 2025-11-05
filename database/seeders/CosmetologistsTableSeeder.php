<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CosmetologistsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cosmetologists')->insert([
            ['full_name' => 'Смирнова Ольга'],
            ['full_name' => 'Кузнецова Елена'],
            ['full_name' => 'Новикова Ирина'],
        ]);
    }
}
