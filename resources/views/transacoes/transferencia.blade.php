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
  </ol>
            
@stop
@section('content')
       
          <div class="row">
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-body">

                    <form role="form" action=" {{ route($dadosPagina['rota'] . 'store')}}" method="post">
                        @csrf
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label for="conta_id_origem">De:</label>
                            <select name="conta_id_origem" id="conta_id_origem" class="form-control">
                              @foreach ($contas as $c)
                              <option value="{{$c->id}}" @if(old('conta_id_origem') == $c->id || $id_sacado == $c->id) selected @endif>{{$c->centrodecusto->nome}} - {{$c->nome}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group col-md-4">
                            <label for="conta_id_destino">Para:</label>
                            <select name="conta_id_destino" id="conta_id_destino" class="form-control">
                              @foreach ($contas as $c2)
                              <option value="{{$c2->id}}" @if(old('conta_id_destino') == $c2->id) selected @endif>{{$c2->centrodecusto->nome}} - {{$c2->nome}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label for="valor">Valor</label>
                            <input type="number" step=".01" class="form-control"  id="valor" value="{{old('valor')}}" name="valor">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label for="obs">Observações:</label>
                            <input type='text' name="obs" value="{{ old('obs')}}" id="obs"  class="form-control">
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
                </div>
                
        <!-- /.content-wrapper -->
@stop


