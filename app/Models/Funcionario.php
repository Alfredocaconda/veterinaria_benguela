<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Funcionario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nome',
        'telefone',
        'email',
        'password',
        'genero',
        'data_contrato',
        'cargo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}