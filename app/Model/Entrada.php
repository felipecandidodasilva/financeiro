<?php

namespace App\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    public const PREFIXO = 'entrada'; // prefido de nome de arquivos
    public const PASTA = 'comprovantes'; // pasta onde será salvo os comprovantes

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

       'user_id', 'conta_id', 'categoria_id', 'nome', 'descricao', 'valor', 'parcela', 'comprovante', 'id_referencia', 'confirmado', 'data',  
    ];

    public function conta()
    {
        return $this->belongsTo('App\Model\Conta');
    }
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

}
