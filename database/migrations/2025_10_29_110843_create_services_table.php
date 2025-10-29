<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->unique();
            $table->integer('price_cents');
            $table->integer('duration_minutes');
            $table->boolean('is_active')->default(true);
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent()->useCurrentOnUpdate();

            // CHECK-и как в схеме
            $table->check('price_cents >= 0', 'services_price_cents_check');
            $table->check('duration_minutes > 0', 'services_duration_minutes_check');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
