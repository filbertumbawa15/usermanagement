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
        Schema::create('config_user', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('salt');
            $table->string('id_level', 100)->nullable();
            $table->string('hp', 14);
            $table->string('photo');
            $table->string('token');
            $table->datetime('last_logged_in')->nullable();
            $table->enum('status', ['aktif', 'tidak']);
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
        Schema::dropIfExists('config_user');
    }
};
