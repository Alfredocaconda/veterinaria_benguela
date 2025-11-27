<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caderneta extends Model
{
    //
    public function funcionario(){
        return $this->belongsTo(Funcionario::class,'id_funcionario');
    }
    public function animal()
    {
        return $this->belongsTo(Animal::class, 'id_animal');
    }

    public function proprietario()
    {
        return $this->belongsTo(Proprietario::class, 'id_proprietario');
    }

      protected static function boot()
    {
        parent::boot();

        static::creating(function ($caderneta) {
            // Buscar último número de registo
            $ultimoNumero = self::max('n_registo');
            $numeroSequencial = $ultimoNumero ? ((int) substr($ultimoNumero, -5)) + 1 : 1;

            // Gerar número no formato REG-ANO-XXXXX
            $caderneta->n_registo = 'REG-' . date('Y') . '-' . str_pad($numeroSequencial, 5, '0', STR_PAD_LEFT);
            
            // Definir data automaticamente
            $caderneta->data = now();
        });
    }
}
