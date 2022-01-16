@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>Criar Centro de Custos</h1>
<a href="{{ route("centrodecusto.create" )}}" class="btn btn-success">Criar</a>

<ol class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li><a href="{{route('centrodecusto.index')}}">Centro de Custos</a></li>
    <li><a href="#">Criar</a></li>
</ol>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header"></div>
            <div class="box-body">

                <form role="form" action=" {{ route('centrodecusto.store')}}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="nome">Nome</label>
                                <input type="text"  class="form-control"  id="nome" value="{{old('nome')}}" name="nome">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="descricao">Descrição:</label>
                                <input type='text' name="descricao" value="{{ old('descricao')}}" id="descricao"  class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="submit" class="btn btn-primary" value="SALVAR">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-footer">
                    @include('includes.alerts')
                </div>
        </div>
    </div>
</div>
@stop