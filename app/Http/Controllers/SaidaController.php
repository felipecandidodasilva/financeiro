<?php

namespace App\Http\Controllers;
use Log;
use App\User;
use App\Model\Conta;
use App\Model\Filtro;
use App\Model\Config;
use App\Model\Categoria;
use App\Model\Data;

use App\Model\Saida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\DateController;
use App\Repositories\HistoricoRepository;

class SaidaController extends Controller
{
    private $saida;
    private $data;

    public function __construct(Saida $saida, Data $data)
    {
        $this->middleware('auth');
        $this->saida = $saida;
        $this->data = $data;
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function periodo(Request $request)
    {
        Config::trataDatas($request);
        return $this->index();

    }

    public function index(Request $request)
    {
        
        $requestLimpa = $request->except('_token');
        
        $filtro = new Filtro;
        $filtro->set($requestLimpa);
        $filtros = $filtro->todos();

        $contasAPagar = $this->saida->filtros($filtros,false);
        $contasPagas = $this->saida->filtros($filtros);

            // Mostra os somatórios nos rodapés titulos etc.
        $dadosPagina = [
            'titulo'            => 'Saídas',
            'subtituloEsquerda' => 'Saídas a Pagar',
            'subtituloDireita'  => 'Saídas Pagas',
            'caminho'           => 'saídas',
            'totalAPagar'       => $contasAPagar->sum('valor'),
            'totalPagas'        => $contasPagas->sum('valor'),
            'restaPagar'        => $contasAPagar->sum('valor') + $contasPagas->sum('valor') ,
            'dataIni'           => $filtro['dataIni'],
            'dataFim'           => $filtro['dataFim'],
            'resta'             => 'pagar',
            'alert-rodape'      => 'alert-danger',
            'rota'              => 'saida.',
            'rotaPeriodo'       => 'saida.periodo',
            'rotaFiltros'       => 'saida.filtros'
        ];
        
        $conta = new Conta(); // Para poder mostra o nome da conta na tabela
        $contas = Conta::contasPorBancos();
        $categorias = Categoria::where('tipo','S')->get();
        
        
        return view("transacoes.io", compact('contasAPagar', 'contasPagas','dadosPagina','contas','conta','categorias','filtros'));
        
    }
    public function filtros(Request $request)
    {
        echo 'Filtros';
        // $filtros = $request->except('_token');
        // $contasAPagar = $this->saida->filtros($filtros);
        // $contasPagas = $this->saida->filtros($filtros,false);

        //     // Mostra os somatórios nos rodapés titulos etc.
        //     $dadosPagina = [
        //         'titulo'            => 'Saídas',
        //         'subtituloEsquerda' => 'Saídas a Pagar',
        //         'subtituloDireita'  => 'Saídas Pagas',
        //         'caminho'           => 'saídas',
        //         'totalAPagar'       => $contasAPagar->sum('valor'),
        //         'totalPagas'        => $contasPagas->sum('valor'),
        //         'restaPagar'        => $contasAPagar->sum('valor') + $contasPagas->sum('valor') ,
        //         'dataIni'           => $filtros['dataIni'],
        //         'dataFim'           => $filtros['dataFim'],
        //         'resta'             => 'pagar',
        //         'alert-rodape'      => 'alert-danger',
        //         'rota'              => 'saida.',
        //         'rotaPeriodo'       => 'saida.periodo',
        //         'rotaFiltros'       => 'saida.filtros'
        //     ];
            
        //     $conta = new Conta(); // Para poder mostra o nome da conta na tabela 
        //     $contas = Conta::contasPorBancos();
        //     $categorias = Categoria::where('tipo','S')->get();

    
        //     return view("transacoes.io", compact('contasAPagar', 'contasPagas','dadosPagina','contas', 'conta','filtros','categorias'));

    }
    

    public function trataNull($var)
    {
        return $var = isset($var) ? $var : 0; 
    }
   public function rapida()
   {
       $dadosPagina = [
            'titulo'            => 'Saída Rápida',
            'caminho'           => 'Saída Rápida',
            'caminhoUrl'        => route('saida.rapida'),
            'data'              => date('Y-m-d'),
       ];
       $contas = Conta::contasPorBancos();
       $categorias = Categoria::where('tipo','S')->orderBy('nome')->get();
    return view('transacoes.io-saida-rapida', compact('dadosPagina','contas','categorias'));

   }

   public function rapidaStore(Request $request)
   {
      
        // VALIDANDO O TIPO DE ARQUIVO
        $name = $this->arquiva($request,Saida::PREFIXO,Saida::PASTA);

        // EM CASO DE FALSO O ARQUIVO É INVÁLIDO
        
       if($name === false)
        return redirect()->back()->withInput();

        
        $input = $request->all();

        $saida = new Saida();
        $saida->comprovante     = $name;
        $saida->nome            = $input['nome'];
        $saida->valor           = $input['valor'];
        $saida->id_referencia   = Conta::idReferencia();
        $saida->data            = date('Y-m-d');
        $saida->parcela         = 1;
        $saida->confirmado      = false; // obrigatóriamente tem que ser salvo false, depois pagamos com o método específico;
        $saida->descricao       = 'Saida rápida.';
        $saida->conta_id        = $input['conta_id'];
        $saida->user_id         = 3; // Fornecedor Padrão
        $saida->categoria_id    = $input['categoria_id'];
        
        if($saida->save()){
            Conta::mensagem('success', 'Conta Salva.');
            
            //caso esteja marcado como pago.
            if(isset($input['confirmado'])){
                $this->pagar($saida->id);
            }

            return redirect()->route('saida.rapida');
        } else {
        $request->flash();
        Conta::mensagem('danger', 'Erro ao salvar conta.');
        Log::error('Erro ao salvar entrada rápida: '. json_encode($entrada));
        return redirect()->back();
        }

   }
    public function create()
    {
        // Mostra os somatórios nos rodapés titulos etc.
        $dadosPagina = [
            'titulo' => 'Nova Saída',
            'subtituloEsquerda' => 'saídas a Receber',
            'subtituloDireita' => 'saídas Recebidas',
            'caminho' => 'saídas',
            'caminhoUrl' => route('saida.index'),
            'rota' => 'saida.',
            'data' => date('Y-m-d')
        ];
        
            $contas = Conta::contasPorBancos();
            $categorias = Categoria::where('tipo','S')->orderBy('nome')->get();
            $users = User::where('fornecedor', true)->get();

        return view('transacoes.io-create', compact('dadosPagina','contas','categorias','users'));
    }

    public function store(Request $request)
    {
        $request->flash();

        $input = $request->all();

        $input['id_referencia'] = Conta::idReferencia();
        
        // NECESSARIO ESSA VARIAVÉL POIS FOR DEPENDE DE UMA VARIÁVEL IMUTAVEL
        $totalParcelas = $input['parcela'];

        $datas = Conta::retornaDatas($input['data'], $input['parcela']);

        for ($i=0; $i < $totalParcelas; $i++) { 
            
            $input['parcela'] = $i + 1;
            $input['data'] = $datas[$i];
            
            $novaSaida = Saida::create($input);
            
            if($novaSaida) {
                Conta::mensagem('success', 'Saída Criada!');
                
                // CASO A SAIDA JÁ TENHA SIDO PAGA, BAIXA NO SALDO DA CONTA
                if($novaSaida->confirmado == true){
                    Conta::saque($novaSaida->conta_id,$novaSaida->valor);
                      //GUARDANDO HISTÓRICO DA TRANSAÇÃO
                        HistoricoRepository::save($novaSaida,"saida", 2 );
                }
                
            } else {
                Conta::mensagem('danger', 'Houve um erro ao salvar saída');
            }
            
        }
            
        return redirect('saida/create')->withInput();



    }


    public function show($id)
    {
      die('Entrou no Método Show');
    }

    public function edit($id)
    {
        $dados = Saida::findOrfail($id);
        
        $outrasParcelas =  Saida::where('id_referencia', $dados->id_referencia)->get(); 
        $vlrTotalParcelas = DB::table('saidas')->where('id_referencia', $dados->id_referencia)->sum('valor');

        // Mostra os somatórios nos rodapés titulos etc.
        $dadosPagina = [
            'titulo' => 'Editar Saída',
            'caminho' => 'Saída',
            'caminhoUrl' => route('saida.index'),
            'rota'      => 'saida.'
        ];

        $contas = Conta::contasPorBancos();
        $categorias = Categoria::where('tipo','S')->get();

       return view('transacoes.io-update', compact('dados','dadosPagina','contas','categorias', 'outrasParcelas','vlrTotalParcelas'));
    }

    public function update(Request $request, $id){

        $saida = Saida::find($id);

        
        if(!$saida){
            Conta::mensagem('danger', 'Saída não encontrada!');
            return redirect( route('saida.edit', $id));
        }
        
        //VALIDANDO SE A CONTA ESTÁ CONFIRMADA
        if(!Conta::contaAtiva($saida->conta_id))
        return redirect()->back()->withInput();
        
        // NÃO PERMITE UPDATE EM UMA SAÍDA JÁ CONFIRMADA
        // SEM ESSA TRAVA O USÁRIO PODE MUDAR O VALRO DA CONTA
        // E BANGUNÇAR O SALDO.
        
        if($saida->confirmado == true){
            Conta::mensagem('danger', 'Para Editar uma saida é necessário primeiro extorná-la!');
            return redirect( route('saida.edit', $id));
        }
        
        // VALIDANDO O TIPO DE ARQUIVO
        $name = $this->arquiva($request,Saida::PREFIXO,Saida::PASTA);

        // EM CASO DE FALSO O ARQUIVO É INVÁLIDO
               if($name === false)
        return redirect()->back()->withInput();
        
        // SE HOUVE UPLOAD E TEM NOME, DELETA-SE O ARQUIVO ANTIGO
        if($name != null && Storage::disk('public')->exists($saida->comprovante))
        Storage::disk('public')->delete($saida->comprovante);

        $dados = $request->all();
        // DEFINE O NOVO NOME DO ARQUIVO
        $dados['comprovante'] = $name;

        $saida->update($dados);
        
        // ATUALIZANDO O SALDO DA CONTA
        if($saida->confirmado == true){
            Conta::saque($saida->conta_id,$saida->valor);
        }

        // PERMANEÇO NA EDIÇÃO POIS AINDA POSSO EDITAR OUTRAS CONTAS DO MESMO GRUPO
        Conta::mensagem('success', 'Saída Atualizada!');
        return redirect( route('saida.edit', $id));
    }

    public function destroy($id){
        $saida = Saida::find($id);
        if(!$saida){
            Conta::mensagem('danger', 'Conta a pagar não encontrada');
            return redirect(route('saida.index'));
        }
        
        $saida->delete();
        Conta::mensagem('success', 'Saída removida com sucesso, para ver as contas removidas vá em Menu>Saidas>Saídas Removidas');
        return redirect(route('saida.index'));

    }

    function pagar($id) {
        $saida = Saida::find($id);
        
        //VERIFICANDO SE A CONTA ESTÁ ATIVA
        if(!Conta::contaAtiva($saida->conta_id))
        return redirect()->back()->withInput();
        
        if($saida){
            $saida->confirmado = true;
            $saida->save();
            // RETIRANDO O VALOR DA CONTA BANCARIA
            Conta::saque($saida->conta_id,$saida->valor);

            //GUARDANDO HISTÓRICO DA TRANSAÇÃO
            HistoricoRepository::save($saida,"saida", 2 );

            Conta::mensagem('success', 'Saída cadastrada e paga com sucesso!');
        } else {
            Conta::mensagem('danger', 'Saída não encontrada!');
        }
        return redirect(route('saida.index'));
        
    }
    
    function estornar($id) {
        $saida = Saida::find($id);

        //VERIFICANDO SE A CONTA ESTÁ ATIVA
        if(!Conta::contaAtiva($saida->conta_id))
        return redirect()->back()->withInput();
  
        if($saida){
            $saida->confirmado = false;
            $saida->save();

            HistoricoRepository::save($saida,"saida", 4 );
            
            Conta::deposito($saida->conta_id,$saida->valor);
            Conta::mensagem('success', 'Saída estornada!');
        } else {
            Conta::mensagem('danger', 'Saída não encontrada!');
        }
        return redirect(route('saida.index'));
        
    }

    public function mensagem($tipo,$texto){
        session()->flash('alert', ['type' => $tipo, 'message' => $texto]);
    }

    public function arquiva(request $request, $prefixo, $pasta)
    {
        /* CUIDA DOS ARQUIVOS A SEREM SALVOS
        / recebe o prefixo do nome do arquivo
        / recebe a pasta onde será salvo o arquivo
        */
        if($request->hasFile('arquivo')){
            if($request->arquivo->getMimeType() == 'application/pdf' 
            or $request->arquivo->getMimeType() == 'image/png'
            or $request->arquivo->getMimeType() == 'image/jpeg'){
                
                // DEFININDO NOME DO ARQUIVO
                $name =  $prefixo . '-' . date('YmdHis') . '.' . $request->arquivo->extension();
                
                // SALVANDO O ARQUIVO COM O NOVO NOME
                $path = $request->file('arquivo')->storeAs($pasta, $name,'public');
                
                // EM CASO DE SUCESSO RETORNA O NOME DO ARQUIVO PARA SER SALVO NO BANCO DE DADOS
                return $pasta . '/' .  $name;
                
            } else {
                // EM CASO DE ARQUIVO INVÁLIDO RETORNA COM MENSAGEM DE ERRO
                Conta::mensagem('danger', 'Tipo de arquivo inválido, aceitos somente PDF ou PNG ou JPEG.');
                Log::error('Arquivo inválido para upload: '. json_encode($request));
                return false;
                
            }
        }
        // CASO NÃO EXISTA ARQUIVO RETORNA NULL
        return null;
    }
}