@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>{{ $dadosPagina['titulo']}}</h1>

<ol class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li><a href="{{route('user.index')}}">Centro de Custos</a></li>
    <li><a href="#">Editar</a></li>
</ol>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                    <form action="{{ route('user.destroy', $user->id)}}" method="POST">
                        @csrf
                        @method("DELETE")
                        <input type="submit" class="btn btn-danger" value="Excluir">
                    </form>
            </div>
            <div class="box-body">

                <form role="form" action=" {{ route('user.update',$user->id)}}" method="post">
                    @method('PUT')    
                    @csrf
                        <input type="hidden" name="_method" value='PUT'>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="nome">Nome</label>
                                <input type="text"  class="form-control"  id="nome" value="{{$user->nome}}" name="nome">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="descricao">Descrição:</label>
                                <input type='text' name="descricao" value="{{ $user->descricao}}" id="descricao"  class="form-control">
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