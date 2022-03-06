<?php

namespace App\Observers;

use App\Model\Entrada;
use App\Model\Historico;

class EntradaObserver
{
    /**
     * Handle the entrada "created" event.
     *
     * @param  \App\Entrada  $entrada
     * @return void
     */
    public function created(Entrada $entrada)
    {
        
    }
    
    /**
     * Handle the entrada "updated" event.
     *
     * @param  \App\Entrada  $entrada
     * @return void
     */
    public function updated(Entrada $entrada)
    {
        $type_id = 1; //ENTRADA

        if (!$entrada->confirmado){ 
            // EM CASO DE ESTORNO
            $type_id =  4;
            $entrada->valor = $entrada->valor * -1;
        }

        Historico::create([
            'descricao'     =>  $entrada->nome,
            'type_id'       =>  $type_id,
            'valor'         =>  $entrada->valor,
            'conta_id'      =>  $entrada->conta_id,
            'date'          =>  $entrada->data,
        ]);
    }

    /**
     * Handle the entrada "deleted" event.
     *
     * @param  \App\Entrada  $entrada
     * @return void
     */
    public function deleted(Entrada $entrada)
    {
        //
    }

    /**
     * Handle the entrada "restored" event.
     *
     * @param  \App\Entrada  $entrada
     * @return void
     */
    public function restored(Entrada $entrada)
    {
        //
    }

    /**
     * Handle the entrada "force deleted" event.
     *
     * @param  \App\Entrada  $entrada
     * @return void
     */
    public function forceDeleted(Entrada $entrada)
    {
        //
    }
}
