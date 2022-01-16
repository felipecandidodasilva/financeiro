<?php

namespace App\Http\Controllers;

use App\Model\Conta;
use App\Model\Centrodecusto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\HistoricoRepository;


class ContaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$contas = Conta::all();
        $centrodecustos = Centrodecusto::all();
        $amount = 100;
        $dadosPagina = [
            'titulo' => 'Listas de Contas',
            'caminho' => 'conta',
            'caminhoUrl' => route('conta.index'),
            'rota'      => 'conta.'
        ];


        return view('contas.index', compact('centrodecustos','amount','dadosPagina'));
    }

   public function create()
    {
        $centrodecustos = Centrodecusto::all();
        $dadosPagina = [
            'titulo' => 'Criar Conta'
        ];
        return view('contas.criar', compact('centrodecustos','dadosPagina'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Centrodecusto::find($request->input('centrodecusto_id'))) {
            Conta::create($request->all());
            Conta::mensagem('success', 'Nova Conta Criada!'); 
            return redirect( route('conta.index'));
        } else {
            Conta::mensagem('danger', 'Houve um erro ao salvar a conta o Centro de Custo não foi encontrado!'); 
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('Metodo show');
    }


    public function transacao(Request $request)
    {
        $tipo = $request->input('tipo');
        $id = $request->input('id');

        $conta = Conta::find($id);
        if ($tipo == 'depositar') {
            $config = [
                'titulo' => 'Depositar',
                'caminho' => 'depositar',
                'descricao' => "Depositado por: " . Auth::user()->name
            ];
        } else {
            $config = [
                'titulo' => 'Sacar',
                'caminho' => 'sacar',
                'descricao' => "Sacado por: " . Auth::user()->name
            ];
        }
        $dadosPagina = [];

        return view('contas.transacao', compact('conta', 'config','dadosPagina'));
    }

    public function transacaoStore(Request $request)
    {

        $tipo = $request->input('tipo');
        $id = $request->input('id');
        
        
        
        // Recebe o id, via get, e o post do formulário com o valor
        $conta = Conta::find($id);
        //dd($conta);
        if ($conta) {

            $historico = new HistoricoRepository;
            $historico->conta_id = $conta->id;
            
            if ($tipo == 'depositar') {
                Conta::deposito($conta->id, $request->input('valor'));
                $historico->descricao = $request->input('descricao');
                $historico->valor = $request->input('valor');
                $tabela = "entrada";
                $type_id = 1;

                Log::info('Incrementado Saldo');
                
            } elseif ($tipo == 'sacar') {
                Conta::saque($conta->id, $request->input('valor')) ;
                $historico->descricao = $request->input('descricao');
                $historico->valor = $request->input('valor');
                $tabela = "saida";
                $type_id = 2;

                Log::info('Decrementado saldo');
                
            } else {
                Log::alert('Erro ao efetuar transação tipo não identificado: ' . $tipo);
                return  redirect()->back();
            }
            

            HistoricoRepository::save($historico, $tabela, $type_id );

            $conta->save();

            return redirect(route('conta.index'));

        } else {
            return redirect()->back();
        }
    }

    
    public function edit($id)
    {
        $conta = Conta::find($id);
        $historico = Historicorepository::listFromContaIdtoDate($conta->id,DateController::getPeriodo());

        // CASO A CONTA NÃO EXISTA OU TENHA SIDO DELETADA
        if (!$conta) {
            Conta::mensagem('danger','Está conta não existe ou está desativada');
            return redirect( route('home'));
        }

        $centrodecustos = Centrodecusto::all();
        $dadosPagina = [
            'titulo' => 'Detalhes da Conta',
            'caminho' => 'conta',
            'rota'      => 'conta.'
        ];
        return view('contas.editar', compact('conta','centrodecustos','historico','dadosPagina'));

    }

    
    public function update(Request $request, $id)
    {
        $conta = Conta::find($id);
        if($conta){
            $input = $request->all();
            $conta->update($input);
            Log::debug('Conta Atualizada Usuario Autenticado: ' . auth()->user()->name . ' - ' . json_encode($input));
            Conta::mensagem('success', 'Conta atualizada com sucesso');
            return redirect()->back();
        }

        Log::debug('Erro ao Atualizar conta Usuario Autenticado: ' . auth()->user()->name . ' - ' . json_encode($input));
        Conta::mensagem('danger', 'Erro ao atualizar conta');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conta = Conta::find($id);
        if(!$conta){
            Conta::mensagem('danger','Conta não encontrada');
            return redirect()->back();
        }


        if($conta->delete()) {
            Conta::mensagem('success', 'Conta excluída com sucesso, as entradas e saídas vinculadas a ela deveram ser migradas pelo usuário no momento do pagamento ou recebimento!');
            return redirect(route('conta.index'));
        }
       
    }
}
