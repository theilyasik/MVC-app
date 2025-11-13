<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('TRUNCATE TABLE services RESTART IDENTITY CASCADE');

        DB::table('services')->insert([
            ['name' => 'Ультразвуковая чистка лица',        'price_cents' => 320000, 'duration_minutes' => 60, 'is_active' => true],
            ['name' => 'Комбинированный уход за кожей',     'price_cents' => 380000, 'duration_minutes' => 75, 'is_active' => true],
            ['name' => 'Массаж лица с лифтинг-эффектом',    'price_cents' => 290000, 'duration_minutes' => 50, 'is_active' => true],
            ['name' => 'Ламинирование бровей',              'price_cents' => 210000, 'duration_minutes' => 45, 'is_active' => true],
            ['name' => 'Окрашивание бровей хной',           'price_cents' => 160000, 'duration_minutes' => 30, 'is_active' => true],
            ['name' => 'Ламинирование ресниц',              'price_cents' => 240000, 'duration_minutes' => 50, 'is_active' => true],
            ['name' => 'SPA-уход для рук',                  'price_cents' => 150000, 'duration_minutes' => 40, 'is_active' => true],
            ['name' => 'Парафинотерапия',                   'price_cents' => 170000, 'duration_minutes' => 35, 'is_active' => true],
            ['name' => 'Мезотерапия лица',                  'price_cents' => 450000, 'duration_minutes' => 60, 'is_active' => true],
            ['name' => 'Пилинг миндальный',                 'price_cents' => 280000, 'duration_minutes' => 45, 'is_active' => true],
            ['name' => 'Пилинг молочный',                   'price_cents' => 260000, 'duration_minutes' => 45, 'is_active' => true],
            ['name' => 'Микротоковая терапия',              'price_cents' => 330000, 'duration_minutes' => 55, 'is_active' => true],
            ['name' => 'Релакс-массаж головы',              'price_cents' => 180000, 'duration_minutes' => 30, 'is_active' => true],
            ['name' => 'Антистрессовый уход',               'price_cents' => 400000, 'duration_minutes' => 80, 'is_active' => true],
            ['name' => 'Экспресс-уход перед мероприятием',  'price_cents' => 250000, 'duration_minutes' => 40, 'is_active' => true],
            ['name' => 'Уход за кожей вокруг глаз',         'price_cents' => 190000, 'duration_minutes' => 35, 'is_active' => true],
            ['name' => 'Гидропилинг Aquapeel',              'price_cents' => 420000, 'duration_minutes' => 70, 'is_active' => true],
            ['name' => 'Карбокситерапия',                   'price_cents' => 360000, 'duration_minutes' => 60, 'is_active' => true],
            ['name' => 'Лифтинг-маска коллагеновая',        'price_cents' => 230000, 'duration_minutes' => 45, 'is_active' => true],
            ['name' => 'Пилинг с ретинолом',                'price_cents' => 390000, 'duration_minutes' => 50, 'is_active' => false],
        ]);
    }
}
