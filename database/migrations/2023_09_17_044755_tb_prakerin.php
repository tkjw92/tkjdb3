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
        Schema::create('tb_prakerin', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->integer('id_dudi');
            $table->string('judul');
            $table->date('tgl');
            $table->longText('detail');
            $table->string('status')->default('null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_prakerin');
    }
};
