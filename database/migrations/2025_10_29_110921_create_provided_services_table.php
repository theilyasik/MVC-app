<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provided_services', function (Blueprint $table) {
            $table->id();

            // FK на сеанс и услугу
            $table->foreignId('session_id')
                ->constrained('sessions')
                ->cascadeOnDelete(); // удаляем оказанные услуги при удалении сеанса

            $table->foreignId('service_id')
                ->constrained('services')
                ->restrictOnDelete(); // услугу удалить нельзя, пока есть ссылки

            // Кол-во и цена
            $table->integer('quantity')->default(1);
            $table->integer('unit_price_cents');

            // Уникальность: одна и та же услуга в сеансе — одна строка
            $table->unique(['session_id', 'service_id'], 'ps_unique_service_per_session');

            // Таймстемпы
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // CHECK-ограничения
        DB::statement("
            ALTER TABLE provided_services
            ADD CONSTRAINT provided_services_quantity_check
            CHECK (quantity >= 1)
        ");

        DB::statement("
            ALTER TABLE provided_services
            ADD CONSTRAINT provided_services_unit_price_cents_check
            CHECK (unit_price_cents >= 0)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('provided_services');
    }
};
