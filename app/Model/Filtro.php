<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Filtro extends Model
{
    private $name = 'filtros';
    private $dataIni;
    private $dataFim;
    private $categoriaId = NULL;
    private $contaId = NULL;
    private $filtros;

    public function __construct()
    {   
        $this->dataIni = date('Y-m-01');
        $this->dataFim = date('Y-m-t');

        $this->filtros = [
            'dataIni'           => $this->dataIni,
            'dataFim'           => $this->dataFim,
            'categoriaId'       => $this->categoriaId,
            'contaId'           => $this->contaId,

        ]; 

       
        if (!session()->has($this->name)) {
           
            session([$this->name => $this->filtros]);
        } else {
            $this->filtros = session($this->name);
        }
        
    }

    public function set($request)
    {
        if($request !== []) {
            session([$this->name => $request]);
        }
    }
    public function todos()
    {
       return $this->filtros;
    }
    public function get($name)
    {
        $this->filtros = session($this->name);
        return $this->filtros[$name];
    }
}
