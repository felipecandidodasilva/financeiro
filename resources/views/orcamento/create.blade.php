@extends('adminlte::page')

@section('title', $dadosPagina['titulo'])

@section('content_header')
@include('includes.headerPages')
            
@stop
@section('content')
       
          <div class="row">
              <div class="col-md-12">
                  <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                  <form role="form" action=" {{ $dadosPagina['rotaForm']}}" method="post">
                    @csrf
                        <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="user_id">Pessoa</label>
                              <select name="user_id" id="user_id" class="form-control">
                                 @foreach ($users as $user)
                                  <option value="{{$user->id}}">{{$user->name}}</option>
                                 @endforeach
                              </select>
                            </div>
                          <div class="form-group col-md-5">
                            <label for="titulo">Titulo</label>
                            <input type="text" class="form-control" id="titulo" name="titulo">
                          </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="valor">Valor</label>
                                <input type="number" step=".01" class="form-control"  id="valor" name="valor">
                            </div>
                            <div class="form-group col-md-4">
                              <label for="status_id">Status</label>
                              <select name="status_id" id="status_id" class="form-control">
                                 @foreach ($status as $s)
                                  <option value="{{$s->id}}">{{$s->descricao}}</option>
                                 @endforeach
                              </select>
                            </div>
                      
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                              <label for="descricao">Descrição:</label>
                              <textarea name="descricao" id="descricao" rows=10 class="form-control"></textarea>
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


