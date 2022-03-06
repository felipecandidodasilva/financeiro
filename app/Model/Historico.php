<?php

namespace App\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Log;


class Historico extends Model
{
    protected $fillable = [

        'conta_id', 'descricao', 'valor', 'type_id', 'date',  
    ];

    public function TransactionType()
    {
        return $this->belongsTo('App\Model\TransactionType','type_id', 'id');
    }

    public function Conta()
    {
        return $this->belongsTo('App\Model\Conta');
    }
}
