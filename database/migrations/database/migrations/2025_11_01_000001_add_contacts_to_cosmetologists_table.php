<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cosmetologists', function (Blueprint $table) {
            $table->string('specialization', 150)->nullable()->after('full_name');
            $table->string('phone', 50)->nullable()->unique()->after('specialization');
            $table->string('email', 254)->nullable()->unique()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('cosmetologists', function (Blueprint $table) {
            $table->dropColumn(['specialization', 'phone', 'email']);
        });
    }
};