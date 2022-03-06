<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Centrodecusto;
use Log;

class Conta extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'centrodecusto_id', 'nome', 'descricao', 'saldo' ,'entrada_rapida',
    ];
    
    public function centrodecusto()
    {
        return $this->belongsTo(Centrodecusto::class);
    }

    public function entrada()
    {
        return $this->hasMany('App\Model\Entrada');
    }

    public function saida()
    {
        return $this->hasMany('App\Model\Saida');
    }

    public function historico()
    {
        return $this->hasMany('App\Model\Historico');
    }

    public static function contaAtiva($id)
    {
        $conta = Conta::find($id);
        
        if(!$conta){
            Conta::mensagem('danger', 'Esta conta está desativada, reative a conta ou escolha outra para prosseguir');
            return false;
        }
        return true;
    }

    public static function deposito($id,$valor)
    {
        $conta = Conta::find($id);
        if(!$conta){
            Conta::mensagem('danger','Conta Inexistente');
            return redirect()->back();
        }

        $conta->saldo = $conta->saldo + $valor;
        //dd($conta);
        $conta->save();
        return true;
    }
    public static function saque($id,$valor)
    {
        $conta = Conta::find($id);
        if(!$conta){
            Conta::mensagem('danger','Conta Inexistente');
            return redirect()->back();
        }

        //  COMO É SAQUE O VALOR ENTRA SUBTRAINDO
        $conta->saldo = $conta->saldo - $valor;
        $conta->save();

        return true;
    }
    public static function idSaidaRapida()
    {
        // BUSCA NO BANCO DE DADOS QUAL REGISTRO TEM UMA SAÍDA RAPIDA SETADA
        // RETORNA UM ID NUMÉRICO
        return 1;
    }
    public static function idReferencia()
    {
        // retorna um valor aleatório para fazer a ligação entre as parcelas de cada conta
        // seja entrada ou saída
        return date('Ymdhis');
    }

    public static function incrementaMes($data) :string
    {
        $partes = explode("-", $data);
        $ano = $partes[0];
        $mes = $partes[1];
        $dia = $partes[2];

        // Guardando a data inicial para caos mude para 
        $diaOriginal = $dia;

        $mes = $mes == '12' ? $mes = '1' : ++$mes; // garante que não há mes 13
        $ano = $mes == '01' ? ++$ano : $ano; // com ingremento no mes 12  o ano aumenta
        $mes = $mes < 10 ? '0' . $mes : $mes; // adiciona o zero para meses menores que 10

        if($dia == 30 || $dia == 31 && $mes == '02') {
            $dia = 01;
            $mes = 03;
        }

        if($dia ==31 && $mes == '02' || $mes == '04' || $mes == '06' || $mes == '09' || $mes == '11'){
            $dia = '01';
            $mes = $mes +1;

            $mes = $mes == '12' ? $mes = '1' : ++$mes; // garante que não há mes 13
            $ano = $mes == '01' ? ++$ano : $ano; // com ingremento no mes 12  o ano aumenta
            $mes = $mes < 10 ? '0' . $mes : $mes; // adiciona o zero para meses menores que 10

        }
        $novaData = $ano . "-" . $mes . "-" . $dia;
        echo $novaData . "<br>";
        return $novaData;
    }

    public static function retornaDatas($data,$numero)
    {
        $parc = array();
        $parc[] = $data;
        //list($dia, $mes, $ano) = explode("/", $data);
        
        $partes = explode("-", $data);
        $ano = $partes[0];
        $mes = $partes[1];
        $dia = $partes[2];

        for($i = 1; $i < $numero;$i++)
        {
            $mes++;
            if ((int)$mes == 13)
            {
                $ano++;
                $mes = 1;
            }
            $tira = $dia;
            while (!checkdate($mes, $tira, $ano))
            {
                $tira--;
            }
            $parc[] = sprintf("%02d-%02d-%s", $ano, $mes, $tira);
        }
        return $parc;
    }
    public static function mensagem($tipo,$texto)
    {
        session()->flash('alert', ['type' => $tipo, 'message' => $texto]);
    }

    public static function registra($acao,$tabela,$dadosAntigos,$dadosNovos = null)
    {
        $mensagem = "
        Usuário Logado: " . auth()->user()->id ."-". auth()->user()->name . "  | Ação: $acao | Tabela: $tabela | Dados Antigos:"
         . json_encode($dadosAntigos) . " | Dados Novos: " . json_encode($dadosNovos);
        
        Log::info($mensagem);
    }

    public static function getNomeConta($id) 
    {
        $conta = Conta::find($id);
        
        if($conta){
            return $conta->nome;
        } else {
            return 'Conta Inexistente';
        }
    }
    
    public static function contasPorBancos()
    {
        // Listo as contas ordenadas pelo centro de custo ou banco
        return Conta::orderBy('centrodecusto_id')->get(); 
    }

  
}
