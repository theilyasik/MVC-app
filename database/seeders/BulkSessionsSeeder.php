<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Cosmetologist;
use App\Models\Service;
use App\Models\Session;

class BulkSessionsSeeder extends Seeder
{
    public function run(): void
    {
        $clients        = Client::all();
        $cosmetologists = Cosmetologist::all();

        if ($clients->isEmpty() || $cosmetologists->isEmpty() || Service::count() === 0) {
            $this->command->warn('Нужно сначала засеять клиентов/косметологов/услуги.');
            return;
        }

        // Сгенерируем ~30 случайных сеансов
        for ($i = 0; $i < 30; $i++) {

            // Берём одну услугу только для расчёта длительности
            $durationService = Service::inRandomOrder()->first();

            $start = Carbon::now()
                ->addDays(random_int(0, 30))
                ->setTime(random_int(9, 18), [0, 30][random_int(0, 1)], 0);

            $end = (clone $start)->addMinutes($durationService->duration_minutes);

            $session = Session::create([
                'client_id'        => $clients->random()->id,
                'cosmetologist_id' => $cosmetologists->random()->id,
                'starts_at'        => $start,
                'ends_at'          => $end,
                'status'           => 'scheduled',
                'room'             => 'Кабинет ' . random_int(1, 5),
                'notes'            => 'Автосгенерированный сеанс',
            ]);

            // Привяжем 1–2 услуги — всегда коллекция моделей
            $pickedServices = Service::inRandomOrder()
                ->limit(random_int(1, 2))
                ->get();

            foreach ($pickedServices as $srv) {
                $session->services()->attach($srv->id, [
                    'quantity'         => random_int(1, 2),
                    'unit_price_cents' => $srv->price_cents,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }

        $this->command->info('Сгенерировано ~30 дополнительных сеансов.');
    }
}
