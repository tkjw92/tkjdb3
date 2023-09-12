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
        Schema::create('tb_soal', function (Blueprint $table) {
            $table->id();
            $table->string('jenis');
            $table->string('type');
            $table->string('mapel');
            $table->string('capaian');
            $table->string('status');
            $table->string('owner');
            $table->string('token');
            $table->integer('kkm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_soal');
    }
};
