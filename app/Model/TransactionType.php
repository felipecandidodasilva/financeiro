<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $fillable = ["name"];
    protected $table = "transactiontypes";

    public function historico()
    {
        return $this->hasMany('App\Model\Historico','id', 'type_id');
    }
}
