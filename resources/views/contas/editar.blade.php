@extends('adminlte::page')

@section('title', 'Home Dashboard')

@section('content_header')
    <h3>Editar Conta {{$conta->nome}}</h3>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="{{ route('conta.index')}}">Contas</a></li>
        <li><a href="">Editar</a></li>
    </ol>
@stop

@section('content')
<div class="box">
    <div class="box-header">
       
    </div>
    <div class="box-body">    
        @include('includes.alerts') 
        <form action="{{ route('conta.update', $conta->id)}}" method="post">
            <input type="hidden" name="_method" value="PUT">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="">Centro de Custo</label>
                <select name="centrodecusto_id" id="" class="form-control">
                    @foreach ($centrodecustos as $ct)
                        <option value="{{ $ct->id }}" @if ($ct->id == $conta->centrodecusto->id) selected
                            
                        @endif>{{ $ct->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nome">Nome</label>
            <input type="text" name="nome" class="form-control"  value="{{$conta->nome}}" placeholder="Dê um nome a sua nova conta">
            </div>
            <div class="form-group">
                <label for="descricao"> Descrição</label>
                <textarea class="form-control" name="descricao" id="descricao" cols="30" rows="2"> {{$conta->nome}}</textarea>
            </div>

            <div class="form-group">
                <button class="btn btn-success" type="submit">Atualizar</button>
            </div>
        </form>
    </div>
    <div class="box-footer">
        <div class="col-xs-12">
            <div class="col-xs-6 col-md-2">
                <form action="{{ route('conta.destroy', $conta->id)}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <input type="submit" class="btn btn-danger" value="Excluir Conta">
                </form>
            </div>
            <div class="col-xs-6 col-md-8">
            <div class="btn-group">
                <a href=" {{ route('conta.transacao', ['tipo'=>'depositar' , 'id' => $conta->id] ) }}" class="btn btn-success"><i class="fa fa-cart-plus" aria-hidden="true"> Depósito</i></a>
                <a href=" {{ route('conta.transacao', ['tipo' => 'sacar', 'id' => $conta->id] ) }}" class="btn btn-danger"><i class="fa fa-cart-plus" aria-hidden="true"> Saque</i></a>
                <a href=" {{ route('transferencia.index', ['id_sacado' => $conta->id] ) }}" class="btn btn-primary"><i class="fa fa-exchange-alt" aria-hidden="true"> Transferencia</i></a>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="box">
        <div class="box-header">
            <h3 class="box-title">Histórico</h3>
        </div>
      
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <th>#</th>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            </thead>
                            <tbody>
                                @foreach ($historico as $h)
                                <tr>
                                <td>{{ $loop->index + 1}}</td>
                                    <td>{{ date('d/m/Y', strtotime($h->date)) }} </td>
                                    <td>{{$h->descricao}}</td>
                                    <td>{{$h->TransactionType->name}}</td>
                                    <td>{{ number_format($h->valor, 2, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

@stop