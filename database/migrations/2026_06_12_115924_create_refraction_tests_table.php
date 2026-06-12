<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refraction_tests', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Kolom data tes refraksi
            $table->string('type'); // 'minus' atau 'plus'
            $table->string('va_score'); // Skor Visual Acuity
            $table->text('conclusion'); // Kesimpulan medis
            $table->integer('confidence'); // Tingkat keyakinan
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refraction_tests');
    }
};