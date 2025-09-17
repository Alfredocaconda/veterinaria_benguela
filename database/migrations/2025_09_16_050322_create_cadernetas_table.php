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
        Schema::create('cadernetas', function (Blueprint $table) {
            $table->id();
            $table->string('nome_proprietario');
            $table->string('endereco');
            $table->string('provincia');
            $table->string('nome_animal');
            $table->string('genero_animal');
            $table->string('especie');
            $table->string('raca');
            $table->string('idade_animal');
            $table->string('microchip_n');
            $table->string('pelagem_comprida');
            $table->string('ondulada');
            $table->string('cor');
            $table->string('cauda_comprida');
            $table->string('n_registo');
            $table->string('data');
            $table->string('id_funcionario')->constrained('funcionario')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadernetas');
    }
};
