<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->integer('price_cents');
            $table->integer('duration_minutes');
            $table->boolean('is_active')->default(true);
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // CHECK-ограничения для Postgres через сырые SQL
        DB::statement('ALTER TABLE services ADD CONSTRAINT services_price_cents_check CHECK (price_cents >= 0)');
        DB::statement('ALTER TABLE services ADD CONSTRAINT services_duration_minutes_check CHECK (duration_minutes > 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
