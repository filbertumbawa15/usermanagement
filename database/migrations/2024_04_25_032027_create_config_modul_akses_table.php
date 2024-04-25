<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('config_modul_akses', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('id_level');
            $table->string('id_config_modul');
            $table->timestamps();
            $table->string('create_user', 100)->nullable();
            $table->string('modified_user', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_modul_akses');
    }
};
