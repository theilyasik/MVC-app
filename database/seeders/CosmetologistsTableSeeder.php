<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CosmetologistsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('TRUNCATE TABLE cosmetologists RESTART IDENTITY CASCADE');

        DB::table('cosmetologists')->insert([
            ['full_name' => 'Ольга Смирнова'],
            ['full_name' => 'Елена Кузнецова'],
            ['full_name' => 'Ирина Новикова'],
            ['full_name' => 'Мария Волкова'],
            ['full_name' => 'Виктория Алексеева'],
            ['full_name' => 'Татьяна Громова'],
            ['full_name' => 'Полина Романова'],
            ['full_name' => 'Наталья Белова'],
            ['full_name' => 'Светлана Лапина'],
            ['full_name' => 'Александра Егорова'],
        ]);
    }
}
