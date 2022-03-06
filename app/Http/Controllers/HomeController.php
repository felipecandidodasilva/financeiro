<?php

namespace App\Http\Controllers;

use App\Model\Filtro;
use App\User;
use App\Model\Conta;
use App\Model\Config;
use App\Model\Categoria;
use App\Model\Data;

use App\Events\HomeEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DateController;


class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     
     public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index(Request $request)
    {
        event(new HomeEvent('Acesso detectado na home'));

        
        $requestLimpa = $request->except('_token');
        
        $filtro = new Filtro;
        $filtro->set($requestLimpa);
        $filtros = $filtro->todos();

        $entradas = DB::table('entradas')
        ->whereBetween('data', DateController::getPeriodo())->orderBy('data')->get();
        $totalEntradas = $entradas->sum('valor');
        
        $saidas = DB::table('saidas')
        ->whereBetween('data', DateController::getPeriodo())->orderBy('data')->get();
        $totalSaidas = $saidas->sum('valor');
        
        $resultado = $totalEntradas - $totalSaidas;
        $classResult = $resultado > 0 ? 'bg-aqua' : 'bg-red';
        
        $dadosPagina = [
            'titulo'            => 'Início - Balanço',
            'classResultado'    => $classResult,
            'subtituloEsquerda' => 'Entradas',
            'subtituloDireita'  => 'Saídas',
            'rota'              => 'home',
            'rotaPeriodo'       => 'home',
            'dataIni'           => DateController::getdataIni(),
            'dataFim'           => DateController::getdataFim(),
            'rotaFiltros'       => 'home.filtros'
        ];

        $conta = new Conta(); // Para poder mostra o nome da conta na tabela
        $contas = Conta::contasPorBancos();
        $categorias = Categoria::all();
        
        return view('home', compact('entradas', 'totalEntradas', 'saidas', 'totalSaidas', 'resultado', 'dadosPagina','filtros','conta','contas','categorias'));
    }
}