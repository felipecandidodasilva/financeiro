@extends('adminlte::page')

@section('title', 'Home Dashboard')

@section('content_header')
    <h1>{{$dadosPagina['titulo']}}</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="{{ route('conta.index')}}">Contas</a></li>
        <li><a href="#">{{$dadosPagina['titulo']}}</a></li>
    </ol>
@stop

@section('content')
<div class="box">
        <div class="box-header">
            <h3></h3>
        </div>
        <div class="box-body">    
            @include('includes.alerts')     

            <form action="{{ route('conta.index')}}" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="">Centro de Custo</label>
                    <select name="centrodecusto_id" id="" class="form-control">
                        @foreach ($centrodecustos as $ct)
                            <option value="{{ $ct->id }}">{{ $ct->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" class="form-control" placeholder="Dê um nome a sua nova conta">
                </div>
                <div class="form-group">
                    <label for="">Saldo da nova conta</label>
                    <input type="number" name="saldo" class="form-control" min=0 step="0.00">
                </div>
                <div class="form-group">
                    <label for="descricao"> Descrição</label>
                    <textarea class="form-control" name="descricao" id="descricao" cols="30" rows="10"></textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-success" type="submit">Criar</button>
                </div>
            </form>
        </div>
    </div>
@stop