<?php

namespace App\Http\Controllers;

use App\Model\orcamento;
use App\User;
use Illuminate\Http\Request;
use stdClass;

class OrcamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataIni = session('dataIni', date('Y-m-01'));
        $dataFim = session('dataFim', date('Y-m-t'));

        $dadosPagina = [
            'titulo' => 'Orçamentos',
            'caminho' => 'Orçamentos',
            'dataIni' => $dataIni,
            'dataFim' => $dataFim,
            'alert-rodape' => 'alert-success',
            'rota' => 'orcamento.',
            'caminhos' => [
                [
                    'descricao' => 'Orçamentos',
                    'rota' => route('orcamento.index')
                ],
                [
                    'descricao' => 'Novo Orçamento',
                    'rota' => route('orcamento.create')
                ],
            ]
        ];

        return view('orcamento.index', compact('dadosPagina'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataIni = session('dataIni', date('Y-m-01'));
        $dataFim = session('dataFim', date('Y-m-t'));

        $users = User::all();
        $dadosPagina = [
            'titulo' => 'Novo Orçamento',
            'dataIni' => $dataIni,
            'dataFim' => $dataFim,
            'rotaForm' => route('orcamento.store'),
            'alert-rodape' => 'alert-success',
            'caminhos' => [
                [
                    'descricao' => 'Orçamentos',
                    'rota' => route('orcamento.index')
                ],
                [
                    'descricao' => 'Novo Orçamento',
                    'rota' => route('orcamento.create')
                ],
            ]
        ];
        
    
        return view('orcamento.create', compact('users','dadosPagina','status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\orcamento  $orcamento
     * @return \Illuminate\Http\Response
     */
    public function show(orcamento $orcamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\orcamento  $orcamento
     * @return \Illuminate\Http\Response
     */
    public function edit(orcamento $orcamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\orcamento  $orcamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, orcamento $orcamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\orcamento  $orcamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(orcamento $orcamento)
    {
        //
    }
}
