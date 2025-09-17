<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Funcionario;
use Illuminate\Support\Facades\Hash;

class FuncionarioSeeder extends Seeder
{
    public function run(): void
    {
        Funcionario::create([
            'name'     => 'Administrador',
            'email'    => 'veterinaria_benguela@gmail.com',
            'password' => Hash::make('1234'),
            'telefone' => '900000000',
            'cargo'   => 'Diretor',
            'n_bi'   => '123456789BA123',
        ]);
    }
}
