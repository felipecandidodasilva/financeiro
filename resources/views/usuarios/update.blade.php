@extends('adminlte::page')

@section('title', $dadosPagina['titulo'])

@section('content_header')
<h1>{{ $dadosPagina['titulo']}}</h1>

<ol class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li><a href="{{route( $dadosPagina['rota'] . 'index')}}"> {{$dadosPagina['rotaAnteriorNome']}}</a></li>
    <li><a href="#">{{ $dadosPagina['rotaAtualNome']}}</a></li>
</ol>
@stop

@section('content')
@include('usuarios.form-update') 
@stop