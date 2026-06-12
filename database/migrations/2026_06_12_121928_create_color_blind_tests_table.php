<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('color_blind_tests', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Kolom data tes buta warna
            $table->integer('score');
            $table->string('status');
            $table->text('recommendation');
            $table->integer('confidence');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('color_blind_tests');
    }
};