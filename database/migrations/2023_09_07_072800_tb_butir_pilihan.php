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
        Schema::create('tb_butir_pilihan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_soal');
            $table->longText('soal');
            $table->longText('pilihan');
            $table->integer('correct');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_butir_pilihan');
    }
};
