<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\Saida;
use App\Model\Conta;
use App\Model\Config;
use App\Model\Categoria;
use Log;

class RelatoriosController extends Controller
{
    private $dataFim;
    private $dataIni;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function trataDatas(Request $request)
    {
        // SE TEM POST, COLOCA NA SESSION
        if ($request->input('dataIni')) {
            session(['dataIni' => $request->input('dataIni')]);
        }
        if ($request->input('dataFim')) {
            session(['dataFim' => $request->input('dataFim')]);
        }
        return redirect()->back();
    }
    public function saidasPorContas()
    {
        $dados = DB::table('saidas')
            ->join('contas','contas.id', 'saidas.conta_id')
            ->selectRaw('contas.id, contas.nome, Sum(valor) as total')
            ->whereBetween('data',[session('dataIni'),session('dataFim')])
            ->orderBy('contas.nome', "ASC")
            ->groupBy('contas.nome','contas.id')
            ->get();

        // Mostra os somatórios nos rodapés titulos etc.
        $dadosPagina = [
            'tabela'            => 'relatorios.saidasPorContas',
            'titulo'            => 'Saídas por Contas',
            'caminho'           => 'saídas',
            'totalAPagar'       => $dados->sum('valor'),
            'totalPagas'        => $dados->sum('valor'),
            'restaPagar'        => $dados->sum('valor') + $dados->sum('valor') ,
            'dataIni'           => $this->dataIni,
            'dataFim'           => $this->dataFim,
            'resta'             => 'pagar',
            'alert-rodape'      => 'alert-danger',
            'rota'              => 'relatorios.saidas.contas',
            'rotaPeriodo'       => 'relatorios.periodo'
        ];
        return view("relatorios.modelo", compact('dados','dadosPagina'));
    }
    public function saidasPorfornecedores()
    {
        $dados = DB::table('saidas')
            ->join('users','users.id', 'saidas.user_id')
            ->selectRaw('users.id, users.name, Sum(valor) as total')
            ->whereBetween('data',[session('dataIni'),session('dataFim')])
            ->orderBy('users.name', "ASC")
            ->groupBy('users.name','users.id')
            ->get();

        // Mostra os somatórios nos rodapés titulos etc.
        $dadosPagina = [
            'tabela'            => 'relatorios.saidasPorFornecedores',
            'titulo'            => 'Saídas por Fornecedores',
            'caminho'           => 'saídas',
            'totalAPagar'       => $dados->sum('valor'),
            'totalPagas'        => $dados->sum('valor'),
            'restaPagar'        => $dados->sum('valor') + $dados->sum('valor') ,
            'dataIni'           => $this->dataIni,
            'dataFim'           => $this->dataFim,
            'resta'             => 'pagar',
            'alert-rodape'      => 'alert-danger',
            'rota'              => 'relatorios.saidas.fornecedores',
            'rotaPeriodo'       => 'relatorios.periodo'
        ];
        return view("relatorios.modelo", compact('dados','dadosPagina'));
    }
    public function saidasPorCategorias()
    {
        $dados = DB::table('saidas')
            ->join('categorias','categorias.id', 'saidas.categoria_id')
            ->selectRaw('categorias.id, categorias.nome, Sum(valor) as total')
            ->whereBetween('data',[session('dataIni'),session('dataFim')])
            ->orderBy('categorias.nome', "ASC")
            ->groupBy('categorias.nome','categorias.id')
            ->get();

            //dd($dados);

        // Mostra os somatórios nos rodapés titulos etc.
        $dadosPagina = [
            'tabela'            => 'relatorios.saidasPorCategorias',
            'titulo'            => 'Saídas por Categorias',
            'caminho'           => 'saídas',
            'totalAPagar'       => $dados->sum('valor'),
            'totalPagas'        => $dados->sum('valor'),
            'restaPagar'        => $dados->sum('valor') + $dados->sum('valor') ,
            'dataIni'           => $this->dataIni,
            'dataFim'           => $this->dataFim,
            'resta'             => 'pagar',
            'alert-rodape'      => 'alert-danger',
            'rota'              => 'relatorios.saidas.categorias',
            'rotaPeriodo'       => 'relatorios.periodo'
        ];
        return view("relatorios.modelo", compact('dados','dadosPagina'));
    }
}
