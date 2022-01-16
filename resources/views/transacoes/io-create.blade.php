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
    <li><a href="/home">Home</a></li>
    <li><a href="{{ $dadosPagina['caminhoUrl']}}">{{ $dadosPagina['caminho']}}</a></li>
    <li><a href="#">Criar</a></li>
  </ol>
            
@stop
@section('content')
       
          <div class="row">
              <div class="col-md-12">
                  <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                  <form role="form" action=" {{ route($dadosPagina['rota'] . 'index')}}" method="post">
                    @csrf
                        <div class="form-row">
                          <div class="form-group col-md-3">
                            <label for="data">Data</label>
                          <input type="date" class="form-control" value='{{$dadosPagina['data']}}' id="data" name="data">
                          </div>
                          <div class="form-group col-md-4">
                              <label for="conta_id">Conta</label>
                              <select name="conta_id" id="conta_id" class="form-control">
                                 @foreach ($contas as $c)
                                  <option value="{{$c->id}}">{{$c->centrodecusto->nome}} - {{$c->nome}}</option>
                                 @endforeach
                              </select>
                            </div>
                          <div class="form-group col-md-5">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome">
                          </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="valor">Valor</label>
                                <input type="number" step=".01" class="form-control"  id="valor" name="valor">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="parcela">Parcela</label>
                                <input type="number"  class="form-control" id="parcela" min=1 name="parcela" value=1>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="confirmado">Pago?</label>
                                <select name="confirmado" id="confirmado" class="form-control">
                                    <option value=0 > NÃO </option>
                                    <option value=1 > SIM </option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="categoria_id">Categoria</label>
                                <select name="categoria_id" id="categoria_id" class="form-control">
                                   @foreach ($categorias as $cat)
                                    <option value="{{$cat->id}}">{{$cat->nome}}</option>
                                   @endforeach
                                </select>
                            </div>
                          <div class="form-group col-md-3 col-xs-12">
                              <label for="user_id">Destinatário</label>
                              <select name="user_id" id="user_id" class="form-control">
                                 @foreach ($users as $user)
                                  <option value="{{$user->id}}">{{$user->name}}</option>
                                 @endforeach
                              </select>
                          </div>
                          <div class="form-group col-md-12">
                              <label for="descricao">Descrição:</label>
                              <textarea name="descricao" id="descricao" rows=3 class="form-control"></textarea>
                          </div>
                        </div>
                        <div class="form-row">
                                <div class="form-group col-md-12">
                                        <input type="submit" class="btn btn-primary" value="SALVAR">
                                </div>
                            </div>
                  <div class="box-footer">
                  </div>
                </form>
              </div>
              </div>
          </div>
    
        <!-- /.content-wrapper -->
@stop


