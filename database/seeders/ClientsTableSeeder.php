<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clients')->insert([
            ['full_name' => 'Иванова Анна', 'phone' => '+7 900 111-22-33', 'email' => 'anna@example.com', 'notes' => null],
            ['full_name' => 'Петров Сергей', 'phone' => '+7 900 222-33-44', 'email' => 'sergey@example.com', 'notes' => null],
            ['full_name' => 'Соколова Мария', 'phone' => '+7 900 333-44-55', 'email' => 'maria@example.com', 'notes' => null],
        ]);
    }
}
