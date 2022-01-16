@extends('adminlte::page')

@section('title', $dadosPagina['titulo'])

@section('content_header')
<div class="row">
    <div class="col-xs-12 col-md-3">
        <h1 style="margin-top: 0;">
                {{$dadosPagina['titulo']}}                
            </h1>
        </div>
        <div class="col-xs-12 col-md-8">
        @include('includes.form-datas')
        </div>
    </div>

    <ol class="breadcrumb">
        <li><a href="/home">Home</a></li>
        <li><a href="#">{{$dadosPagina['caminho']}}</a></li>
    </ol>
@stop

@section('content')
@if (count($dados) > 0)
    
@include($dadosPagina['tabela'])
@else
    <h2>Não há dados suficientes para gerar esse relatório</h2>
@endif
        
@stop