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
            $table->string('n_registo');
            $table->string('data');
            $table->foreignId('id_animal')
              ->constrained('animals')
              ->onDelete('cascade');

        $table->foreignId('id_proprietario')
              ->constrained('proprietarios')
              ->onDelete('cascade');

        $table->foreignId('id_funcionario')
              ->constrained('funcionarios')
              ->onDelete('cascade');
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
