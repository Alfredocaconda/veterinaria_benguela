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
        Schema::create('vacinacao_raivas', function (Blueprint $table) {
            $table->id();
            $table->string('data');
            $table->string('n_lote');
            $table->unsignedBigInteger('vacinador');
            $table->foreign('vacinador')->references('id')->on('funcionarios')->onDelete('cascade');

            $table->unsignedBigInteger('id_funcionario');
            $table->foreign('id_funcionario')->references('id')->on('funcionarios')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacinacao_raivas');
    }
};
