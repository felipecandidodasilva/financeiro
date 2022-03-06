<?php

namespace App\Repositories;

use App\Model\Historico;
use App\Model\TransactionType;
use App\Http\Controllers\DateController;

class HistoricoRepository
{

    public static function ajustaValor($table, $type, $value)
    {
        /**
         * Em caso de saida o valor deve entrar negativado
         * Em caso de estorno o valor tem que ser o oposto da tabela
         */

         //dd($table,$type, $value);


        switch ($table) {
            case 'entrada':
                $value = $type == 4 ? $value * -1 : $value;
                break;
            case 'saida':
                $value = $type == 4 ? $value : $value * -1;
                break;
        }

        return $value;
    }
    public static function listFromContaIdtoDate($conta_id,$periodo){
      
      $historico = Historico::where('conta_id', $conta_id)->orderBy('id')->get();
      return $historico->whereBetween('date',DateController::getPeriodo());
      
    }

    public static function save($historico, $table, $type_id)
    {
        /**
         * Tipos de Transações
         * 1 - Entrada
         * 2 - Saída
         * 3 - Transferência
         * 4 - Estorno
         */

        $historico->valor = HistoricoRepository::ajustaValor($table, $type_id, $historico->valor);
        //dd($historico->valor);
        $historico->type_id = $type_id;
        $historico->data = isset($historico->data) ? $historico->data  : date('Y-m-d');

        if (!$historico->descricao) {

            //verificando se veio como descrição ou como nome
            $historico->descricao = $historico->descricao ? $historico->descricao : "Descrição Não informada ";
        }

        Historico::create([
            'descricao' => $historico->descricao,
            'type_id' => $historico->type_id,
            'valor' => $historico->valor, // POSITIVO PARA ESTORNO NEGATIVO PARA PAGAMENTO
            'conta_id' => $historico->conta_id,
            'date' => $historico->data,
        ]);

        return true;
    }
    
    public static function transferencia($historico, $contaOrigem, $contaDestino)
    {

        // registrando na conta de origem a saida da transferencia
        Historico::create([
            'descricao' => $historico['obs'] . ' - ' . $contaDestino->nome,
            'type_id' => 3,
            'valor' => $historico['valor'] * -1,
            'conta_id' => $contaOrigem->id,
            'date' => date('Y-m-d'),
        ]);

        // registrando na conta de destino a entrada da transferencia
        Historico::create([
            'descricao' => $historico['obs'] . ' - ' . $contaOrigem->nome,
            'type_id' => 3,
            'valor' => $historico['valor'],
            'conta_id' => $contaDestino->id,
            'date' => date('Y-m-d'),
        ]);

    }

}
