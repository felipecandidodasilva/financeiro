<?php

namespace App\Observers;

use App\Model\Saida;
use App\Model\Historico;

class SaidaObserver
{
    
    /**
     * Handle the saida "updated" event.
     *
     * @param  \App\Saida  $saida
     * @return void
     */
    public function updated(Saida $saida)
    {
        dd($saida);
        
        $type_id =  4; // ESTORNO

        
        if ($saida->confirmado){ 
            // EM CASO DE PAGAMENTO
            $type_id = 2; //SAIDA
            $saida->valor = $saida->valor * -1; // VALRO ENTRA NORMALMENTE COMO NEGATIVO
        }

        Historico::create([
            'descricao'     =>  $saida->nome,
            'type_id'       =>  $type_id, // 4 PARA STORNO 1 PARA PAGAMENTO
            'valor'         =>  $saida->valor, // POSITIVO PARA ESTORNO NEGATIVO PARA PAGAMENTO
            'conta_id'      =>  $saida->conta_id,
            'date'          =>  $saida->data,
        ]);
    }

    /**
     * Handle the saida "deleted" event.
     *
     * @param  \App\Saida  $saida
     * @return void
     */
    public function deleted(Saida $saida)
    {
        //
    }

    /**
     * Handle the saida "restored" event.
     *
     * @param  \App\Saida  $saida
     * @return void
     */
    public function restored(Saida $saida)
    {
        //
    }

    /**
     * Handle the saida "force deleted" event.
     *
     * @param  \App\Saida  $saida
     * @return void
     */
    public function forceDeleted(Saida $saida)
    {
        //
    }
}
