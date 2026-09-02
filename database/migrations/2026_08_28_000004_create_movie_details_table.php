<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movie_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('diretor', 120)->nullable();
            $table->unsignedSmallInteger('duracao_minutos')->nullable();
            $table->string('classificacao', 20)->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_details');
    }
};
