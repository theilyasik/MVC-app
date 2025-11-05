<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('services')->insert([
            ['name' => 'Чистка лица',        'price_cents' => 250000, 'duration_minutes' => 60, 'is_active' => true],
            ['name' => 'Пилинг',             'price_cents' => 300000, 'duration_minutes' => 45, 'is_active' => true],
            ['name' => 'Массаж лица',        'price_cents' => 200000, 'duration_minutes' => 40, 'is_active' => true],
            ['name' => 'Ламинирование бровей','price_cents' => 180000, 'duration_minutes' => 50, 'is_active' => false],
        ]);
    }
}
