<?php

namespace App\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Model\Filtro;

class Saida extends Model
{
    
    public const PREFIXO = 'saida'; // prefido de nome de arquivos
    public const PASTA = 'comprovantes'; // pasta onde será salvo os comprovantes

    protected $fillable = [

        'user_id', 'conta_id', 'categoria_id', 'nome', 'descricao', 'valor', 'parcela', 'id_referencia', 'confirmado', 'data', 'comprovante'  
    ];

    public static function  totalPorPeriodo($confirmado, $agp, $agp_id)
    {
        // $agp = Agrupamento -> Por qual coluna o relatório será agrupado
        // Dessa forma reaproveito o código para vários relatórios 
        $dataIni = session('dataIni', date('Y-m-01')); //se houver dados para dataIni usa-os caso não usa o segundo parâmetro
        $dataFim = session('dataFim', date('Y-m-t'));

        $contasPagas = DB::table('saidas')
        ->selectRaw('sum(valor) as total')
        ->where([
            ['confirmado', $confirmado],
            [$agp, $agp_id],
            ['data', '>=', $dataIni],
            ['data', '<=', $dataFim],
        ])->get();

        return $contasPagas->first()->total;
    }
    public static function  totalPorPeriodoPorFornecedor($confirmado, $user_id)
    {
        $dataIni = session('dataIni', date('Y-m-01')); //se houver dados para dataIni usa-os caso não usa o segundo parâmetro
        $dataFim = session('dataFim', date('Y-m-t'));

        $contasPagas = DB::table('saidas')
        ->selectRaw('sum(valor) as total')
        ->where([
            ['confirmado', $confirmado],
            ['user_id', $user_id],
            ['data', '>=', $dataIni],
            ['data', '<=', $dataFim],
        ])->get();

        return $contasPagas->first()->total;
    }

    public function conta()
    {
        return $this->belongsTo('App\Model\Conta');
    }
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function categorias()
    {
        return $this->belongsTo('App\Model\Categorias');
    }

    public function filtros($filtros, $confirmado = true)
    {
        
       
        $result = DB::table('saidas')
            ->join('categorias', 'saidas.categoria_id', '=', 'categorias.id')
            ->join('contas', 'saidas.conta_id', '=', 'contas.id')
            ->select('saidas.*', 'categorias.nome as categoria','contas.nome as conta');
        
        $result = $result->where(function ($query) use($filtros, $confirmado) {
            $query->where('data', '>=', $filtros['dataIni']);
            $query->where('data', '<=', $filtros['dataFim']);
            $query->where('confirmado', $confirmado);
            if($filtros['contaId']) {
                $query->where('conta_id','=',$filtros['contaId'] );
            }
            if($filtros['categoriaId'] ){
                $query->where('categoria_id','=',$filtros['categoriaId'] );
            }
        })
        ->orderBy('data', 'asc')
        ->get();
        // ->toSql();

        // dd($result);
        
        return $result;
    }
}
