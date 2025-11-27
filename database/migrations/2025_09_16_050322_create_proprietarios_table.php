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
        Schema::create('proprietarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('provincia');
            $table->string('municipio');
            $table->string('bairro');
            $table->string('telefone');
            $table->string('email');
            $table->string('n_bi');
            $table->string('id_funcionario')->constrained('funcionarios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proprietarios');
    }
};
