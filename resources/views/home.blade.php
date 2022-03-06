@extends('adminlte::page')

@section('title', $dadosPagina['titulo'])

@section('content_header')
<div class="row">
    <div class="col-xs-12 col-md-3">
        <h1 style="margin-top: 0;">
                {{$dadosPagina['titulo']}}                
            </h1>
        </div>
    </div>

    <ol class="breadcrumb">
        <li><a href="#">Início</a></li>
    </ol>
@stop

@section('content')
@include('includes.form-filtros')
<div class="row">
    <div class="col-md-4 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
            <h3>{{  number_format($totalEntradas,2,",",".") }}</h3>

            <p>Entradas</p>
            </div>
            <div class="icon">
            <i class="fa fa-shopping-cart"></i>
            </div>
            
        </div>
    </div>
    <div class="col-md-4 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{  number_format($totalSaidas,2,",",".") }}</h3>

            <p>Saídas</p>
            </div>
            <div class="icon">
            <i class="ion ion-pie-graph"></i>
            </div>
            
        </div>
    </div>
    <div class="col-md-4 col-xs-12">
        <!-- small box -->
        <div class="small-box {{ $dadosPagina['classResultado']}}">
            <div class="inner">
            <h3>{{  number_format($resultado,2,",",".") }}</h3>

            <p>Resultado</p>
            </div>
            <div class="icon">
            <i class="fa fa-shopping-cart"></i>
            </div>
            
        </div>
    </div>
</div> {{-- .row --}}

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
                                <th style="width: 10px">#</th>
                                <th>Vencimento</th>
                                <th>Entrada</th>
                                <th>Parc.</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entradas as $E)
                                
                                <tr>
                                    <td>{{ $E->id }}</td>
                                    <td>{{ date('d/m/Y', strtotime($E->data)) }}</td>
                                    <td><a href="{{ route("entrada.edit", $E->id) }}"><b>{{ $E->nome }}</b></a>
                                    </td>
                                    <td>{{ $E->parcela}}</td>
                                    <td>{{ number_format($E->valor,2,",",".") }}</td>
                                    
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$dadosPagina['subtituloDireita']}}</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Vencimento</th>
                                        <th>Saída</th>
                                        <th>Parc.</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($saidas as $S)
                                    
                                    <tr>
                                        <td>{{$S->id}}</td>
                                        <td>{{ date('d/m/Y', strtotime($S->data)) }}</td>
                                        <td><a href="{{ route('saida.edit', $S->id) }}"><b>{{ $S->nome }}</b></a>
                                        </td>
                                        <td>{{$S->parcela}}</td>
                                        <td>{{ number_format($S->valor,2,",",".") }}</td>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
      
    </div> {{-- .row --}}
    
@stop