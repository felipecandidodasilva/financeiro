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
              <div class="col-xs-12 col-md-6">
                  <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                  <form role="form" action="{{ route('saida.rapida.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                      <div class="form-row">
                          <div class="form-group col-xs-12 col-md-6">
                            <label for="id_conta">Conta</label>
                            <select name="conta_id" id="conta_id" class='form-control'>
                                @foreach ($contas as $c)
                                @if (old('conta_id') != null)
                                <option value="{{ $c->id }}" @if (old('conta_id') == $c->id) selected @endif>{{$c->nome}}</option>
                                @else
                                <option value="{{ $c->id }}" @if ($c->saida_rapida == true) selected @endif>{{$c->nome}}</option>
                                @endif
                                @endforeach
                              </select>
                            </div>
                            
                            <div class="form-group col-xs-12 col-md-6">
                              <label for="categoria_id">Categoria</label>
                              <select name="categoria_id" id="categoria_id" class='form-control'>
                                @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" @if (old('categoria_id') == $categoria->id) selected @endif>{{$categoria->nome}}</option>
                                @endforeach
                              </select>
                            </div>
                        <div class="form-group col-xs-12 col-md-6">
                          <label for="nome">Nome</label>
                          <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome')}}" required>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                          <label for="valor">Valor</label>
                          <input type="number" step=".01" class="form-control"  id="valor" name="valor" value="{{ old('valor')}}" required>
                        </div>
                        <div class="form-group col-xs-12 col-md-6 form-check">
                          <input class="form-check-input" type="checkbox" name='confirmado' value="1" id="defaultCheck1" checked>
                          <label class="form-check-label" for="defaultCheck1">
                            Pagamento Confirmado
                          </label>
                        </div>
                        <!--
                        <div class="form-group col-xs-12">
                            <label for="arquivo">Comprovante</label>
                            <input type="file"  class="form-control"  id="arquivo" name="arquivo">
                        </div>
                      -->

                        <div class="form-group col-xs-12">
                            <input type="submit" class="btn btn-primary" style='margin-top: 25px;' value="SALVAR">
                        </div>
                    </div>
                  </form>
                  <div class="box-footer">
                  </div>
              </div>
              </div>
          </div>
    
        <!-- /.content-wrapper -->
@stop


