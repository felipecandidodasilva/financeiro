@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>Centro de Custos</h1>
<a href="{{ route("centrodecusto.create" )}}" class="btn btn-success">Criar</a>

<ol class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li><a href="#">Centro de Custos</a></li>
</ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
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
                                <th>Descrição</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($centrodecustos as $C)
                                
                                <tr>
                                    <td>{{ $C->id }}</td>
                                    <td>{{ $C->nome }}</td>
                                    <td><a href="{{route('centrodecusto.edit', $C->id)}}">{{ $C->descricao}}</a></td>
                                    <td><a href="{{ route('centrodecusto.destroy', $C->id)}}"
                                        class="btn btn-danger btn-xs pull-right"><i class="fa fa-trash-o"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $centrodecustos->links() }}
                </div>
            </div>
        </div>
    </div>
@stop