<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Conta;

class Centrodecusto extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nome', 'descricao'
    ];
    
    public function conta()
    {
        return $this->hasMany(Conta::class);
    }    
}
