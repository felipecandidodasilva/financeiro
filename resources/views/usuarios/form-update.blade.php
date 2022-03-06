@extends('adminlte::page')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                    <form action="{{ route($dadosPagina['rota'] . 'destroy', $user->id)}}" method="POST">
                        @csrf
                        @method("DELETE")
                        <input type="submit" class="btn btn-danger" value="Excluir">
                    </form>
            </div>
            <div class="box-body">

                <form role="form" action=" {{ route($dadosPagina['rota'] . 'update', $user->id)}}" method="post">
                    @method('PUT')    
                    @csrf
                        <input type="hidden" name="_method" value='PUT'>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Nome:</label>
                                <input type="text"  class="form-control"  id="name" value="{{$user->name}}" name="name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="contato">Contato:</label>
                                <input type="text"  class="form-control"  id="contato" value="{{$user->contato}}" name="contato">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 ">
                                <label for="cpf">CPF:</label>
                                <input type='number' name="cpf" value="{{ $user->cpf}}" id="cpf"  class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 ">
                                <label for="cnpj">CNPJ:</label>
                                <input type='number' name="cnpj" value="{{ $user->cnpj}}" id="cnpj"  class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">E-mail:</label>
                                <input type='email' name="email" value="{{ $user->email}}" id="email"  class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nascimento">Data Nasc.:</label>
                                <input type='data' name="nascimento" value="{{ $user->nascimento}}" id="nascimento"  class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-xs-12 ">
                                <label for="detalhes">Detalhes:</label>
                                <textarea name="detalhes" id=""  class="form-control">{{ $user->detalhes}}</textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-xs-12 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cliente"  name="cliente"
                                    @if ($user->cliente == true) checked @endif >
                                    <label class="form-check-label" for="cliente">
                                        Cliente
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="fornecedor"  name="fornecedor"
                                    @if ($user->fornecedor == true) checked @endif >
                                    <label class="form-check-label" for="fornecedor">
                                        Fornecedor
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="funcionario"  name="funcionario"
                                    @if ($user->funcionario == true) checked @endif >
                                    <label class="form-check-label" for="funcionario">
                                        Funcionário
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="cep">CEP:</label>
                                <input type='text' name="cep" value="{{ $user->cep}}" id="postal_code"  class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="logradouro">Logradouro:</label>
                                <input type='text' name="logradouro" value="{{ $user->logradouro}}" id="" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="numero">Número:</label>
                                <input type='text' name="numero" value="{{ $user->numero}}" id="numero"  class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 ">
                                <label for="bairro">Bairro:</label>
                                <input type='text' name="bairro" value="{{ $user->bairro}}" id="bairro"  class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 ">
                                <label for="cidade">Cidade:</label>
                                <input type='text' name="cidade" value="{{ $user->cidade}}" id="locality" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2 ">
                                <label for="detalhes">UF:</label>
                                <input type='text' name="estado" value="{{ $user->estado}}" maxlength="2"  class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="submit" class="btn btn-primary" value="SALVAR">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-footer">
                    @include('includes.alerts')
                </div>
        </div>
    </div>
</div>
@stop