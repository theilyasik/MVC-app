<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('client_id')->unsigned();
            $table->integer('cosmetologist_id')->unsigned();

            $table->timestampTz('starts_at');
            $table->timestampTz('ends_at');

            $table->string('room', 50)->nullable();
            $table->string('status', 20)->default('scheduled');
            $table->text('notes')->nullable();

            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Внешние ключи
            $table->foreign('client_id')
                  ->references('id')->on('clients')
                  ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('cosmetologist_id')
                  ->references('id')->on('cosmetologists')
                  ->onUpdate('cascade')->onDelete('restrict');

            // Индексы для поиска расписания
            $table->index(['client_id', 'starts_at'], 'idx_sessions_client_time');
            $table->index(['cosmetologist_id', 'starts_at'], 'idx_sessions_cosm_time');

            // CHECK-и
            $table->check("status in ('scheduled','done','canceled','no_show')", 'sessions_status_enum');
            $table->check('ends_at > starts_at', 'sessions_time_window');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
