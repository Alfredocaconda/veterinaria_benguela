<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    //
    public function funcionario(){
        return $this->belongsTo(Funcionario::class,'id_funcionario');
    }
    public function proprietario(){
        return $this->belongsTo(Proprietario::class,'id_proprietario');
    }
}
