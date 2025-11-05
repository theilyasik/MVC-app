<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id(); // integer serial
            $table->foreignId('client_id')->constrained('clients')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('cosmetologist_id')->constrained('cosmetologists')->cascadeOnUpdate()->restrictOnDelete();

            $table->timestampTz('starts_at');
            $table->timestampTz('ends_at');

            $table->string('room', 50)->nullable();
            $table->string('status', 20)->default('scheduled');
            $table->text('notes')->nullable();

            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Индексы
            $table->index(['client_id', 'starts_at'], 'idx_sessions_client_time');
            $table->index(['cosmetologist_id', 'starts_at'], 'idx_sessions_cosm_time');
        });

        // CHECK: статус — одно из перечисления
        DB::statement("
            ALTER TABLE sessions
            ADD CONSTRAINT sessions_status_enum
            CHECK (status IN ('scheduled','done','canceled','no_show'))
        ");

        // CHECK: окно времени — окончание позже начала
        DB::statement("
            ALTER TABLE sessions
            ADD CONSTRAINT sessions_time_window
            CHECK (ends_at > starts_at)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
