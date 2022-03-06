@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>{{$dadosPagina['titulo']}}</h1>

<ol class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li><a href="#">{{$dadosPagina['titulo']}}</a></li>
</ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2>Lista </h2>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lista as $L)
                                
                                <tr>
                                    <td>{{ $L->id }}</td>
                                    <td>{{ $L->nome}}</a></td>
                                    <td> @if ($L->tipo == 'E') Entrada @else Saída @endif </td>
                                    <td><a href="{{ route('categoria.edit', $L->id)}}" class="btn btn-warning btn-xs pull-right"> <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('categoria.destroy', $L->id)}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-xs pull-right"><i class="fa fa-trash-o"></i> </button>
                                    </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
   @include($dadosPagina['form'])
    </div>
@stop