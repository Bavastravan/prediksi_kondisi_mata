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
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->integer('age');
            $table->json('symptoms'); // Menyimpan gejala yang dipilih
            $table->string('image_path'); // Nama file foto
            $table->string('result'); // Penyakit yang terdeteksi
            $table->float('confidence'); // Skor keyakinan AI
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};
