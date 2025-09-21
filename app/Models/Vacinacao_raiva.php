<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacinacao_raiva extends Model
{
    //
      public function funcionario(){
        return $this->belongsTo(Funcionario::class,'id_funcionario');
    }
      public function vacinadorFuncionario()
    {
        return $this->belongsTo(Funcionario::class, 'vacinador');
    }

}
