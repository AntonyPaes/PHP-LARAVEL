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
        Schema::create('jogo_user', function (Blueprint $table) {
            $table->foreignId('jogo_id')->constrained()->onDelete('cascade');

            // A CORREÇÃO ESTÁ AQUI: 'user_id' em vez de 'use_id'
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->primary(['jogo_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jogos_user');
    }
};
