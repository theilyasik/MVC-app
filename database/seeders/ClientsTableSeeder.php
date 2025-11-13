<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('TRUNCATE TABLE clients RESTART IDENTITY CASCADE');

        DB::table('clients')->insert([
            ['full_name' => 'Анна Кузнецова',      'phone' => '+7 900 101-01-01', 'email' => 'anna.kuz@example.com',      'notes' => 'Любит процедуры с ароматерапией.'],
            ['full_name' => 'Сергей Петров',       'phone' => '+7 900 102-02-02', 'email' => 'sergey.petrov@example.com', 'notes' => 'Предпочитает вечерние записи.'],
            ['full_name' => 'Мария Соколова',      'phone' => '+7 900 103-03-03', 'email' => 'maria.sok@example.com',      'notes' => 'Чувствительная кожа, нужен мягкий уход.'],
            ['full_name' => 'Екатерина Орлова',    'phone' => '+7 900 104-04-04', 'email' => 'ekaterina.orlova@example.com','notes' => null],
            ['full_name' => 'Андрей Попов',        'phone' => '+7 900 105-05-05', 'email' => 'andrey.popov@example.com',   'notes' => 'Просит напоминание за сутки.'],
            ['full_name' => 'Наталья Фролова',     'phone' => '+7 900 106-06-06', 'email' => 'natalia.frolova@example.com','notes' => null],
            ['full_name' => 'Ольга Миронова',      'phone' => '+7 900 107-07-07', 'email' => 'olga.mironova@example.com',  'notes' => 'Любит экспресс-процедуры.'],
            ['full_name' => 'Владимир Левин',      'phone' => '+7 900 108-08-08', 'email' => 'vladimir.levin@example.com','notes' => null],
            ['full_name' => 'Дарья Никитина',      'phone' => '+7 900 109-09-09', 'email' => 'daria.nikitina@example.com','notes' => 'Постоянный клиент по пятницам.'],
            ['full_name' => 'Ирина Полякова',      'phone' => '+7 900 110-10-10', 'email' => 'irina.polyakova@example.com','notes' => null],
        ]);
    }
}
