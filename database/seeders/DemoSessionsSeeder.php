<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Cosmetologist;
use App\Models\Service;
use App\Models\Session;

class DemoSessionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('TRUNCATE TABLE provided_services RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE sessions RESTART IDENTITY CASCADE');

        $clients        = Client::orderBy('id')->get();
        $cosmetologists = Cosmetologist::orderBy('id')->get();
        $services       = Service::where('is_active', true)->orderBy('id')->get();

        if ($clients->isEmpty() || $cosmetologists->isEmpty() || $services->isEmpty()) {
            $this->command?->warn('Нужно сначала засеять клиентов, косметологов и услуги.');
            return;
        }

        $cosmetologistCount = $cosmetologists->count();
        $serviceCount       = $services->count();

        foreach ($clients as $index => $client) {
            $sessionPerClient = random_int(2, 3);

            for ($i = 0; $i < $sessionPerClient; $i++) {
                $cosmetologist = $cosmetologists[($index + $i) % $cosmetologistCount];
                $serviceSample = $services[($index + $i) % $serviceCount];

                $start = Carbon::now()->addDays($index * 2 + $i)->setTime(10 + ($i * 2), [0, 30][random_int(0, 1)], 0);
                $end   = (clone $start)->addMinutes($serviceSample->duration_minutes);

                $session = Session::create([
                    'client_id'        => $client->id,
                    'cosmetologist_id' => $cosmetologist->id,
                    'starts_at'        => $start,
                    'ends_at'          => $end,
                    'room'             => 'Кабинет ' . (($index + $i) % 5 + 1),
                    'status'           => 'scheduled',
                    'notes'            => 'Плановый визит клиента ' . $client->full_name,
                ]);

                $attachedServices = $services
                    ->shuffle()
                    ->take(random_int(1, 2));

                foreach ($attachedServices as $service) {
                    $session->services()->attach($service->id, [
                        'quantity'         => random_int(1, 2),
                        'unit_price_cents' => $service->price_cents,
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ]);
                }
            }
        }
    }
}
