<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviaAvisoDev;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Model\Conta;
use Log;
//use Illuminate\Database\Eloquent\SoftDeletes;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $lista = User::all();
        $dadosPagina = [
            'titulo'    => 'Usuários',
            'form'      => 'usuarios.form-create'
        ];
        return view('usuarios.index', compact('lista','dadosPagina'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'email' => [ 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => [ 'string', 'min:4', 'confirmed'],
            ]);

        $input = $this->trataInput($request);
        
        $criado =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'cliente' => $input['cliente'],
            'funcionario' => $input['funcionario'],
            'fornecedor' => $input['fornecedor']
        ]);
      

        if($criado){
            Conta::mensagem('success', 'Usuário Criado!');
            Mail::to(env('MAIL_DESENV','SUPORTE@COSTACANDIDO.COM.BR'))->send(new EnviaAvisoDev("Novo Usuário Cadastrado."));
        } else {
            Conta::mensagem('danger', 'Erro ao Criar usuário!');
            return  redirect(route('user.index'));
        }
        // depois dos dados básicos, vamos ao  cadastro detalhado
        return  redirect(route('user.edit',$criado->id));
    }
    public function show($id)
    {
        echo "Metodo show";
    }
    public function edit($id)
    {
        $lista = User::all();
        $user = User::findOrFail($id);

        $dadosPagina = [
            'titulo'        => 'Editar Usuário: ' . $user->name,
            'form'          => 'usuarios.form-update',
            'rota'  => 'user.',
            'rotaAtualNome'  => 'Alteração',
            'rotaAnteriorNome'  => 'Usuários',
        ];

        return view('usuarios.update', compact('dadosPagina','user'));
    }
    public function detalhes($id)
    {
        $user = User::findOrFail($id);

        $dadosPagina = [
            'titulo'    => 'Mais detalhes',
            'route'      => 'user.detalhes'
        ];

        return view('usuarios.detalhes', compact('dadosPagina','user'));
    }
    public function update(Request $request, $id)
    {
        // A SENHA SÓ É ALTERADA VIA ESQUECI A SENHA 
        $user = User::findOrFail($id);
        // SE HOUVE TROCA DE EMAIL O SISTEMA VERIFICA SE EXISTE OUTRO IGUAL
        if ($user->email != $request->email) {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                ]);
            }
        
            $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            ]);

        $input = $request->all();
        $input['cliente'] = isset($input['cliente']) ? true : false;
        $input['fornecedor'] = isset($input['fornecedor']) ? true : false;
        $input['funcionario'] = isset($input['funcionario']) ? true : false;
        $user->update($input);
            return redirect()->back();
    }
    public function destroy($id)
    {
        //GARANTINDO A NÃO EXCLUSÃO DE USUÁRIOS DE SISTEMA
        if ($id == 1 or $id == 1 ) {
            Conta::mensagem('danger','Desculpe o usuário de ID 1 e 2, não podes ser removidos, Você pode renomeá-lo e mudar sua senha.');
            return redirect()->back();
        }

        if ($id == auth()->user()->id)  {
            Conta::mensagem('danger','Desculpe para remover o usuário logado é necessário sair dessa conta e entrar com outra conta!');
            return redirect()->back();
        }

        $usuario = User::findOrFail($id);
        $usuario->delete();
        Conta::registra("DELETE","users", $usuario);
        Conta::mensagem("success",'Usuário Excluído');
        return redirect()->back();
    }
    public static function parabens()
    {
        
        $dados = [
            'empresa' => [
                'nome' => 'GM Elétrica'
            ],
            'cliente' => [
                'nome'  => 'Felipe Silva'
            ],
            ];

        Mail::send('mail.parabens', $dados, function ($message) {
            $message->from('john@johndoe.com', 'John Doe');
            $message->sender('john@johndoe.com', 'John Doe');
            $message->to('john@johndoe.com', 'John Doe');
            $message->cc('john@johndoe.com', 'John Doe');
            $message->bcc('john@johndoe.com', 'John Doe');
            $message->replyTo('john@johndoe.com', 'John Doe');
            $message->subject('Subject');
            $message->priority(3);
            $message->attach('pathToFile');
        });
    }

    public function trataInput(Request $request )
    {
        $input = $request->all();
        $input['cliente'] = isset($input['cliente']) ? true : false;
        $input['fornecedor'] = isset($input['fornecedor']) ? true : false;
        $input['funcionario'] = isset($input['funcionario']) ? true : false;
        $input['email'] = isset($input['email']) ? isset($input['email']) : 'sistema' . Date('ms') . '@Sistema.com.br';
        $input['password'] = isset($input['password']) ? isset($input['password']) : 'sistema';

        return $input;
    }
}
