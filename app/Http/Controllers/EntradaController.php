<?php

namespace App\Http\Controllers;

use App\User;
use App\Model\Conta;
use App\Model\Config;
use App\Model\Entrada;
use App\Model\Categoria;
use App\Repositories\HistoricoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class EntradaController extends Controller
{
    protected $dataIni;
    protected $dataFim;

    public function __construct()
    {
        $this->middleware('auth');
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

    public function index()
    {
        $dataIni = session('dataIni', date('Y-m-01'));
        $dataFim = session('dataFim', date('Y-m-t'));
        

        $contasPagas = DB::table('entradas')
        ->join('categorias', 'entradas.categoria_id', '=', 'categorias.id')
        ->select('entradas.*', 'categorias.nome as categoria')
        ->where([
            ['confirmado', true],
            ['data', '>=', $dataIni],
            ['data', '<=', $dataFim],
            ])->orderBy('data','desc')->get();
            
            $contasAPagar = DB::table('entradas')
            ->join('categorias', 'entradas.categoria_id', '=', 'categorias.id')
            ->select('entradas.*', 'categorias.nome as categoria')
            ->where([
            ['confirmado', false],
            ['data', '>=', $dataIni],
            ['data', '<=', $dataFim],
            ])->orderBy('data')->get();

            //dd($contasAPagar);
            //dd($contasAPagar->sum('valor'));

        // Mostra os somatórios nos rodapés titulos etc.
        $dadosPagina = [
            'titulo' => 'Entradas',
            'subtituloEsquerda' => 'Entradas a Receber',
            'subtituloDireita' => 'Entradas Recebidas',
            'caminho' => 'Entradas',
            'totalAPagar' => $contasAPagar->sum('valor'),
            'totalPagas' => $contasPagas->sum('valor'),
            'restaPagar' => $contasAPagar->sum('valor') + $contasPagas->sum('valor') ,
            'dataIni' =>$dataIni,
            'dataFim' =>$dataFim,
            'resta' => ' receber',
            'alert-rodape' => 'alert-success',
            'rota' => 'entrada.',
            'rotaPeriodo' => 'entrada.periodo'
        ];
        
        $conta = new Conta(); // Para poder mostra o nome da conta na tabela 

        return view("transacoes.io", compact('contasAPagar', 'contasPagas','dadosPagina','conta'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Mostra os somatórios nos rodapés titulos etc.
        $dadosPagina = [
            'titulo' => 'Nova Entrada',
            'caminho' => 'Entradas',
            'caminhoUrl' => route('entrada.index'),
            'subtituloEsquerda' => 'Entradas a Receber',
            'subtituloDireita' => 'Entradas Recebidas',
            'data' => date('Y-m-d'),
            'rota' => 'entrada.'
        ];
        
       $contas = Conta::contasPorBancos();
        $categorias = Categoria::where('tipo','E')->get();
        $users = User::where('cliente', true)->get();
        return view('transacoes.io-create', compact('dadosPagina','contas','categorias','users'));
    }
    
    public function rapida(){
        // Mostra os somatórios nos rodapés titulos etc.
        $dadosPagina = [
            'titulo' => 'Nova Entrada',
            'caminho' => 'Entradas',
            'caminhoUrl' => route('entrada.index'),
            'subtituloEsquerda' => 'Entradas a Receber',
            'subtituloDireita' => 'Entradas Recebidas',
            'data' => date('Y-m-d'),
            'rota' => 'entrada.'
        ];
        
       $contas = Conta::contasPorBancos();
        $categorias = Categoria::where('tipo','E')->get();
        return view('transacoes.io-create', compact('dadosPagina','contas','categorias'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        //dd($input);
        $input['id_referencia'] = Conta::idReferencia();
        $datas = Conta::retornaDatas($input['data'], $input['parcela']);

        // NECESSARIO ESSA VARIAVÉL POIS FOR DEPENDE DE UMA VARIÁVEL IMUTAVEL
        $totalParcelas = $input['parcela'];
        
        for ($i = 0; $i < $totalParcelas; $i++) { 
            
            $input['parcela'] = $i + 1;
            $input['data'] = $datas[$i];

            $novaEntrada = Entrada::create($input);
            
            if($novaEntrada) {
                Conta::mensagem('success', 'Entrada Criada!');
                
                // CASO A ENTRADA JÁ TENHA SIDO PAGA, BAIXA NO SALDO DA CONTA
                if($novaEntrada->confirmado == true){
                    Conta::deposito($novaEntrada->conta_id,$novaEntrada->valor);
                }
                
            } else {
                Conta::mensagem('danger', 'Houve um erro ao salvar Entrada');
            }
            
        }

        return redirect('/entrada');
    }

    public function show($id)
    {
      die('Essa parte do sistema ainda não está habilitada: Método Show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados = Entrada::findOrfail($id);
        $outrasParcelas =  Entrada::where('id_referencia', $dados->id_referencia)->get(); 
        $vlrTotalParcelas = DB::table('entradas')->where('id_referencia', $dados->id_referencia)->sum('valor');
        // Mostra os somatórios nos rodapés titulos etc.
        $dadosPagina = [
            'titulo' => 'Editar Entrada',
            'caminho' => 'Entrada',
            'caminhoUrl' => route('entrada.index'),
            'rota'      => 'entrada.'
        ];

       $contas = Conta::contasPorBancos();
        $categorias = Categoria::where('tipo','E')->get();

       return view('transacoes.io-update', compact('dados','dadosPagina','contas','categorias', 'outrasParcelas','vlrTotalParcelas'));
    }


    public function update(Request $request, $id)
    {
        $entrada = Entrada::find($id);
        if(!$entrada){
            Conta::mensagem('danger', 'Entrada não encontrada!');
            return redirect( route('entrada.edit', $id));
        }
        
        $dados = $request->all();
        // NÃO PERMITE UPDATE EM UMA ENTRADA JÁ CONFIRMADA
        // SEM ESSA TRAVA O USÁRIO PODE MUDAR O VALOR DA CONTA
        // E BANGUNÇAR O SALDO.

        if($entrada->confirmado == true){
            Conta::mensagem('danger', 'Para Editar uma entrada é necessário primeiro extorná-la!');
            return redirect( route('entrada.edit', $id));
        }

         // VALIDANDO O TIPO DE ARQUIVO
         $name = $this->arquiva($request,entrada::PREFIXO,entrada::PASTA);

         // EM CASO DE FALSO O ARQUIVO É INVÁLIDO
        if($name === false)
        return redirect()->back()->withInput();
        
         // SE HOUVE UPLOAD E TEM NOME, DELETA-SE O ARQUIVO ANTIGO
         if($name != null && Storage::disk('public')->exists($entrada->comprovante))
         Storage::disk('public')->delete($entrada->comprovante);
        
        // PEGANDO OS INPUTS 
        $dados = $request->all();
 
        // DEFINE O NOVO NOME DO ARQUIVO
        $dados['comprovante'] = $name;

        // SALVANDO AS ALTERAÇÕES
        $entrada->update($dados);

        // ATUALIZANDO O SALDO DA CONTA
        if($entrada->confirmado == true){
            Conta::deposito($entrada->conta_id,$entrada->valor);
        }

        Conta::mensagem('success', 'Entrada Atualizada!');
        return redirect( route('entrada.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entrada = Entrada::find($id);
        if(!$entrada){
            Conta::mensagem('danger', 'Conta a pagar não encontrada');
            return redirect(route('entrada.index'));
        }
        
        $entrada->delete();
        Conta::mensagem('success', 'Saída removida com sucesso, para ver as contas removidas vá em Menu>entradas>Saídas Removidas');
        return redirect(route('entrada.index'));
        
    }

    function pagar($id) {
        $entrada = Entrada::find($id);
        if($entrada){
            $entrada->confirmado = true;
            $entrada->save();

            HistoricoRepository::save($entrada,"entrada", 1 );

            // atualiza o saldo da conta
            Conta::deposito($entrada->conta_id,$entrada->valor);
            Conta::mensagem('success', 'Entrada recebida com sucesso!');
        } else {
            Conta::mensagem('danger', 'Entrada não encontrada!');
        }
        return redirect(route('entrada.index'));
        
    }

    function estornar($id) {
        $entrada = Entrada::find($id);
        if($entrada){
            $entrada->confirmado = false;
            $entrada->save();

            HistoricoRepository::save($entrada,"entrada", 4 );
            
            // atualiza o saldo da conta
            Conta::saque($entrada->conta_id,$entrada->valor);
           Conta::mensagem('success', 'Entrada estornada!');
        } else {
            Conta::mensagem('danger', 'Entrada não encontrada!');
        }
        return redirect(route('entrada.index'));
        
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