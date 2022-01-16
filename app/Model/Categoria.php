<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nome', 'tipo'
    ];
    
    public static function idSaidaRapida()
    {
        return 1;
    }
    public function saidas()
    {
        return $this->hasMany('App\Model\Saidas');
    }
}
