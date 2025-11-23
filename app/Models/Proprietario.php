<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proprietario extends Model
{
    //
      public function funcionario(){
        return $this->belongsTo(Funcionario::class,'id_funcionario');
    }
      public function animal(){
        return $this->belongsTo(Animal::class,'id_animal');
    }
}
