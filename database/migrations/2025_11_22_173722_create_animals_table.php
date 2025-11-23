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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('genero');
            $table->string('especie');
            $table->string('raca');
            $table->string('idade');
            $table->string('pelagem_comprida');
            $table->string('ondulada');
            $table->string('cor');
            $table->string('cauda_comprida');
            $table->string('id_proprietario')->constrained('proprietario')->onDelete('cascade');
            $table->string('id_funcionario')->constrained('funcionario')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
