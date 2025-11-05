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

        $clients       = Client::orderBy('id')->take(3)->get();
        $cosmetologists= Cosmetologist::orderBy('id')->take(3)->get();
        $services      = Service::where('is_active', true)->orderBy('id')->take(3)->get();

        if ($clients->isEmpty() || $cosmetologists->isEmpty() || $services->isEmpty()) {
            $this->command?->warn('Нужно сначала засидить клиентов/косметологов/услуги.');
            return;
        }

        // 1-й сеанс
        $s1 = Session::create([
            'client_id'        => $clients[0]->id,
            'cosmetologist_id' => $cosmetologists[0]->id,
            'starts_at'        => Carbon::now()->addDays(1)->setTime(10, 0),
            'ends_at'          => Carbon::now()->addDays(1)->setTime(11, 0),
            'room'             => '101',
            'status'           => 'scheduled',
            'notes'            => 'Демонстрационный сеанс #1',
        ]);
        $s1->services()->attach($services[0]->id, [
            'quantity'          => 1,
            'unit_price_cents'  => $services[0]->price_cents,
        ]);

        // 2-й сеанс (две услуги в одном сеансе)
        $s2 = Session::create([
            'client_id'        => $clients[min(1, $clients->count()-1)]->id,
            'cosmetologist_id' => $cosmetologists[min(1, $cosmetologists->count()-1)]->id,
            'starts_at'        => Carbon::now()->addDays(2)->setTime(12, 0),
            'ends_at'          => Carbon::now()->addDays(2)->setTime(13, 30),
            'room'             => '202',
            'status'           => 'scheduled',
            'notes'            => 'Демонстрационный сеанс #2',
        ]);
        $s2->services()->attach($services[0]->id, [
            'quantity'          => 1,
            'unit_price_cents'  => $services[0]->price_cents,
        ]);
        if ($services->count() > 1) {
            $s2->services()->attach($services[1]->id, [
                'quantity'          => 1,
                'unit_price_cents'  => $services[1]->price_cents,
            ]);
        }

        // 3-й сеанс
        $s3 = Session::create([
            'client_id'        => $clients[min(2, $clients->count()-1)]->id,
            'cosmetologist_id' => $cosmetologists[min(2, $cosmetologists->count()-1)]->id,
            'starts_at'        => Carbon::now()->addDays(3)->setTime(15, 0),
            'ends_at'          => Carbon::now()->addDays(3)->setTime(16, 0),
            'room'             => '303',
            'status'           => 'scheduled',
            'notes'            => 'Демонстрационный сеанс #3',
        ]);
        $s3->services()->attach($services[min(2, $services->count()-1)]->id, [
            'quantity'          => 2,
            'unit_price_cents'  => $services[min(2, $services->count()-1)]->price_cents,
        ]);
    }
}
