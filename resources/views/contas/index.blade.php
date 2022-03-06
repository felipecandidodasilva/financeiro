@extends('adminlte::page')

@section('title', 'Saldo')

@section('content_header')
    <h1>Contas</h1>
    <a href="{{ route("conta.create" )}}" class="btn btn-success">Criar</a>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
    </ol>
@stop

@section('content')
@foreach ($centrodecustos as $c)
    <h2> {{ $c->nome }} </h2>

    <div class="row">
        @foreach ($c->conta as $conta)
            <div class="col-xs-12 col-md-3">
                <div class="box">
                    <div class="box-header">
                        <h4 class="display-4">
                            {{ $conta->nome}}
                        </h4>
                        <a href=" {{ route('conta.transacao', ['tipo'=>'depositar' , 'id' => $conta->id] ) }}" class="btn btn-xs btn-primary"><i class="fa fa-cart-plus" aria-hidden="true"> Depósito</i></a>
                        
                        @if ($amount > 0)
                        <a href=" {{ route('conta.transacao', ['tipo' => 'sacar', 'id' => $conta->id] ) }}" class="btn btn-xs btn-danger"><i class="fa fa-cart-plus" aria-hidden="true"> Saque</i></a>
                        @endif
                    </div> <!--box-header -->
                    <div class="box-body">
                        @include('includes.alerts')
                    @if ($conta->saldo > 0)
                    <div class="small-box bg-green">
                        @else
                        <div class="small-box bg-red">
                            @endif
                            <div class="inner">
                                <h3>R$ {{ number_format($conta->saldo, 2, ',','.') }}</h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-cash"></i>
                            </div>
                        
                            <a href="{{ route('conta.edit', $conta->id) }}" class="small-box-footer">Extrato <i class="fas fa-chart-line fa-fx"></i></a>
                            </div>
                        </div> <!--box-body -->
                </div> <!--box -->
            </div>
        @endforeach
    </div> {{-- row --}} 
@endforeach

@stop