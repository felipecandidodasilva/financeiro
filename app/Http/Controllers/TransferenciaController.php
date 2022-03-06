<?php

namespace App\Http\Controllers;

use App\Model\Conta;
use App\Model\Historico;
use App\Repositories\HistoricoRepository;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferenciaController extends Controller
{
    use SoftDeletes;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //VERIFICO SE JÁ VEIO DEFINIDO O SACADO
        $id_sacado = $request->get('id_sacado') ? $request->get('id_sacado') : null;
         // Mostra os somatórios nos rodapés titulos etc.
         $dadosPagina = [
            'titulo' => 'Nova Transferência',
            'caminho' => 'Transferências',
            'caminhoUrl' => route('transferencia.index'),
            'data' => date('Y-m-d'),
            'rota' => 'transferencia.'
        ];
        
        $contas = Conta::all();
        $transferencias = Historico::where('type_id',1)->paginate(10);
        return view('transacoes.transferencia', compact('contas','dadosPagina','transferencias','id_sacado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->flash();
        $input = $request->all();

        if($input['conta_id_origem'] == $input['conta_id_destino'] ){
            Conta::mensagem('danger', 'A conta de Origem deve ser diferente da conta de Destino');
            return redirect()->back( );
        }

        $contaOrigem = Conta::find($input['conta_id_origem']);
        $contaDestino = Conta::find($input['conta_id_destino']);


        // ajustando o novo saldo das contas
        Conta::saque($contaOrigem->id, $input['valor']);
        Conta::deposito($contaDestino->id, $input['valor']);

        HistoricoRepository::transferencia($input,$contaOrigem,$contaDestino);

       
        
        Conta::mensagem('success', 'Transferência realizada com sucesso');
        return redirect(route("conta.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}