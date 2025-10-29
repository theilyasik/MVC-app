<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('provided_services', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('session_id')->unsigned();
            $table->integer('service_id')->unsigned();

            $table->integer('quantity')->default(1);
            $table->integer('unit_price_cents');

            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Внешние ключи
            $table->foreign('session_id')
                  ->references('id')->on('sessions')
                  ->onDelete('cascade'); // удаляем услуги при удалении приёма

            $table->foreign('service_id')
                  ->references('id')->on('services')
                  ->onDelete('restrict'); // нельзя удалить услугу, если есть проведённые

            // Уникальность услуги в рамках одного приёма
            $table->unique(['session_id','service_id'], 'ps_unique_service_per_session');

            // CHECK-и
            $table->check('quantity >= 1', 'provided_services_quantity_check');
            $table->check('unit_price_cents >= 0', 'provided_services_unit_price_cents_check');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provided_services');
    }
};
