<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\EnviaAvisoDev;
use Illuminate\Http\Request;
use App\Model\Centrodecusto;
use App\Model\Conta;
use Log;

class CentrodecustoController extends Controller
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
        $centrodecustos = Centrodecusto::paginate(5);
        return view('centrodecustos.index', compact('centrodecustos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('centrodecustos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome'      => 'required',
            'descricao' => 'required'
        ]);

        $input = $request->all();

        if (Centrodecusto::create($input)) {
            Conta::mensagem('success', 'Novo Centro de Custo criado!');

            //$mensagem = "Novo Cadastro de Centro de Custo ID: " .  $input["id"] . " Nome: " . $input["nome"] . " # Usuário Autenticado: " . auth()->user()->name;
            
            // Mail::send('mail.aviso', ['mensagem' => $mensagem], function ($message) {
            //     $message->from('financeiro@costacandido.com.br', 'Sistema Financeiro');
            //     $message->to('felipe.candido8@gmail.com', 'Felipe Cândido');
            // });
            
               
     
            
            
        } else {

            // enviar email para o ADM 
            Log::error('Erro ao Salvar Centro de Custo Usuário Autenticado: ' . auth()->user()->name . ' - '. json_encode($input));
            Conta::mensagem('danger', 'Houve um erro ao salvar esse centro de custo.');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $centrodecusto = Centrodecusto::find($id);

        if(count($centrodecusto->conta) > 0) {
            Conta::mensagem('danger', 'Existe Contas relacionadas a esse centro de custos, primeiro remova as contas para depois excluír o centro de custo');
            return redirect()->back();
        }
        if(!$centrodecusto) {
            Conta::mensagem('danger', 'O centro de custo não existe');
            return redirect()->back();
        }
        
        Centrodecusto::destroy($id);
        Conta::mensagem('success', 'Centro de custo removido');
        
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dadosPagina = [
            'titulo'    => "Centro de Custos - Edição",
            'tituloLista'    => "Contas Vinculadas",
            'rota'      => "centrodecusto.",
            'rotaLista' => "conta."
        ];
        $centrodecusto = Centrodecusto::find($id);
        return view('centrodecustos.edit',compact('centrodecusto','dadosPagina'));
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
        $centro = Centrodecusto::find($id);

        if($centro) {
            $input = $request->all();
            $centro->update($input);
            Conta::mensagem('success',"Centro de custo atualizado");
        } else {
            Conta::mensagem('danger',"Houve um erro ao atualizar centro de custos");
        }

        return redirect(route("centrodecusto.edit",$id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $centrodecusto = Centrodecusto::find($id);
        if(!$centrodecusto){
            Conta::mensagem('danger','Centro de custos não encontrado');
            return redirect()->back();
        }

        $contas = Conta::where('centrodecusto_id', $id)->get();
        if (count($contas) > 0) {
            Conta::mensagem('danger','Existem contas vinculadas a esse centro de custo, exclua primeiro as contas vinculadas');
            return redirect()->back();
        } else {
           echo "deletando...";
        }
        

    }
 
}
