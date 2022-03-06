<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Categoria;
use App\Model\Conta;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista = Categoria::all();

        $dadosPagina = [
            'titulo'    => 'Categorias',
            'form'      => 'categorias.form-create'
        ];

        return view('categorias.index', compact('lista','dadosPagina'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nome' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'string']
            ]);
            
        $request = $request->all();

        $criado =  Categoria::create([
            'nome' => $request['nome'],
            'tipo' => $request['tipo'],
        ]);

        if($criado){
            Conta::mensagem('success', 'Categoria Criada!');
        } else {
            Conta::mensagem('danger', 'Erro ao Criar Categoria!');
        }

        return  redirect(route('categoria.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo "Metodo show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lista  = Categoria::all();
        $categoria   = Categoria::findOrFail($id);

        $dadosPagina = [
            'titulo'    => 'Editar Categoria: ' . $categoria->nome,
            'form'      => 'categorias.form-update'
        ];

        return view('categorias.index', compact('lista','dadosPagina','categoria'));
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
        $categoria = Categoria::findOrFail($id);
        // SE HOUVE TROCA DE tipo O SISTEMA VERIFICA SE EXISTE OUTRO IGUAL
        

            $request->validate([
            'tipo' => ['required', 'string'],
            'nome' => ['required', 'string', 'max:255'],
            ]);
        $input = $request->all();
        
        $categoria->update($input);
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
       
        $categoria = Categoria::findOrFail($id);
        Conta::registra("DELETE","categorias", $categoria);
        $categoria->delete();
        Conta::mensagem("success",'categoria Excluída');
        return redirect()->back();
    }
}
