@extends('adminlte::page')

@section('title', $config['titulo'])

@section('content_header')
    <h1>Efetuar {{$config['titulo']}}</h1>
    <h3>Saldo: {{$conta->saldo}}</h3>
    <h4>{{$conta->centrodecusto->nome . " | " . $conta->nome}}</h4>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">{{ $config['caminho'] }}</a></li>
    </ol>
@stop

@section('content')
<div class="box">
        <div class="box-header">
            <h3> {{$config['titulo']}}</h3>
        </div>
        <div class="box-body">    
            @include('includes.alerts')     

            <form action="{{ route('conta.transacaoStore', [ 'tipo' => $config['caminho'], 'id' =>$conta->id ] ) }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="valor">Valor a para {{ $config['titulo'] }}.</label>
                    <input type="number" name="valor" id="valor" class="form-control" step="0.01" min=0.01>
                </div>
                <div class="form-group">
                    <label for="obs">Descrição</label>
                    <input type="text" name="descricao" id="descricao" class="form-control" value="{{ $config['descricao'] }}" >
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">{{ $config['titulo']}}</button>
                </div>
            </form>
        </div>
    </div>
@stop