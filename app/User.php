<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','cep','logradouro','numero',
        'bairro','cidade','estado','telefone','nascimento','cpf',
        'cnpj','cliente','funcionario','fornecedor','contato', 'detalhes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function saida()
    {
        return $this->hasMany('App\Model\Saida');
    }
    public function entrada()
    {
        return $this->hasMany('App\Model\Entrada');
    }
}
