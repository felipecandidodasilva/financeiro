@extends('adminlte::page')

@section('title', 'Saldo')

@section('content_header')
<div class="row">
    <div class="col-xs-12 col-md-3">
        <h1 style="margin-top: 0;">
                {{$dadosPagina['titulo']}}                
            </h1>
            <a href="{{ route($dadosPagina['rota'] . "create" )}}" class="btn btn-success">Criar</a>
        </div>
        <div class="col-xs-12 col-md-6">
        @include('includes.form-datas')
        </div>
    </div>

    <ol class="breadcrumb">
        <li><a href="/home">Home</a></li>
        <li><a href="#">{{$dadosPagina['caminho']}}</a></li>
    </ol>
@stop

@section('content')
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{$dadosPagina['subtituloEsquerda']}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Vencimento</th>
                                    <th>{{$dadosPagina['titulo']}}</th>
                                    <th>Conta</th>
                                    <th>Valor</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dados as $CA)
                                    
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($CA->data)) }}</td>
                                        <td><a href="{{ route($dadosPagina['rota'] . "edit", $CA->id) }}"><b>{{ $CA->nome }}</b></a>
                                        </td>
                                        <td>{{ $conta::getNomeConta($CA->conta_id)}}</td>
                                        <td>{{ number_format($CA->valor,2,",",".") }}</td>
                                        <td>
                                            <a href="{{ route($dadosPagina['rota'] . "pagar" , $CA->id)}}"
                                                    class="btn btn-success btn-xs pull-right"><i class="fa fa-arrow-right"></i>
                                                    Pagar</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <h2>Total R$ {{ number_format($dadosPagina['totalAPagar'],2,",",".") }}</h2>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
            <h5 class="alert {{$dadosPagina['alert-rodape']}}">Total de {{$dadosPagina['titulo']}} {{ number_format($dadosPagina['restaPagar'],2,",",".") }}</h5>
            </div>
        </div>
        
@stop