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
    <li><a href="#">Editar</a></li>
  </ol>
@stop
@section('content')
          <div class="row">
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header">
                        
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form role="form" action="{{ route($dadosPagina['rota'] .  'update', $dados->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                        <div class="form-row">
                          <div class="form-group col-md-3">
                            <label for="data">Data</label>
                          <input type="date" class="form-control" value='{{$dados->data}}' id="data" name="data">
                          </div>
                          <div class="form-group col-md-4">
                              <label for="conta_id">Conta</label>
                              <select name="conta_id" id="conta_id" class="form-control">
                                 @foreach ($contas as $c)
                                  <option value="{{$c->id}}" 
                                    @if ($c->id == $dados->conta_id) 
                                      selected
                                    @endif
                                    @if ($c->deleted_at != null)
                                    disabled
                                    @endif
                                    >
                                    {{$c->centrodecusto->nome}} - {{$c->nome}}</option>
                                 @endforeach
                              </select>
                            </div>
                          <div class="form-group col-md-5">
                            <label for="nome">Nome</label>
                          <input type="text" value='{{ $dados->nome}}' class="form-control" id="nome" name="nome">
                          </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="valor">Valor</label>
                                <input type="number" step=".01" class="form-control" value='{{ $dados->valor}}'  id="valor" name="valor">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="parcela">Qtd. Parcelas</label>
                                <input type="text"  class="form-control" id="parcela" value='{{ $dados->parcela}}' min=1 name="parcela" value=1>
                            </div>
                    
                            <div class="form-group col-md-4">
                                <label for="categoria_id">Categoria</label>
                                <select name="categoria_id" id="categoria_id" class="form-control">
                                   @foreach ($categorias as $cat)
                                    <option value="{{$cat->id}}" @if ($dados->categoria_id == $cat->id) selected
                                      @endif>{{$cat->nome}}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="descricao">Descrição:</label>
                            <textarea name="descricao" id="descricao" rows=10 class="form-control"> {{$dados->descricao}}</textarea>
                            </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-xs-12">
                            <label for="arquivo">Comprovante (Caso já exista um comprovante, este será substituído.)</label>
                              <input type="file"  class="form-control"  id="arquivo" name="arquivo">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="col-xs-12">
                              @if( isset($dados->comprovante) && $dados->comprovante != null)
                              <h4> <a href='{{ asset("storage/$dados->comprovante") }}' target="_blank">Visualizar Comprovante</a> </h4>
                              @endif
                            </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <input type="submit" class="btn btn-primary" value="SALVAR">
                          </div>
                        </div>
                  </form>

                  
                  <form action="{{ route($dadosPagina['rota'] . 'destroy', $dados->id)}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <input type="submit" class="btn btn-danger btn-xs" value="Excluir">
                  </form>
                  <a href="{{ route($dadosPagina['rota'] . "pagar" , $dados->id)}}"
                  class="btn btn-success btn-xs">
                  Pagar</a>

                  </div>
                  <div class="box-footer">
                    @if (count($outrasParcelas) > 1)
                      <div class="row">
                          <div class="col-xs-12 col-md-6">
                            <h3 class="box-title">Demais Parcelas</h3>
                              <div class="table-responsive">
                                  <table class="table table-striped table-hover">
                                      <thead>
                                        <th>#</th>
                                        <th>Data</th>
                                        <th>Parcela</th>
                                        <th>Descrição</th>
                                        <th>Valor</th>
                                        <th>Pago</th>
                                      </thead>
                                      <tbody>
                                            @foreach ($outrasParcelas as $p)
                                                
                                            <tr>
                                            <td>{{ $loop->index + 1}}</td>
                                              <td>{{ date('d/m/Y', strtotime($p->data)) }} </td>
                                              <td>{{$p->parcela}} </td>
                                              <td><a href=" {{route($dadosPagina['rota'] .  'edit',$p->id)}}">{{$p->nome}} </a></td>
                                              <td>R$ {{ number_format($p->valor, 2, ',', '.') }}</td>
                                              <td>@if($p->confirmado == 1)  SIM @else NÃO @endif </td>
                                            </tr>
                                            @endforeach
                                      </tbody>
                                      <tfoot>
                                          <tr>
                                            <td colspan="4">Total</td>
                                            <td>R$ {{ number_format($vlrTotalParcelas, 2, ',', '.') }}</td>
                                          </tr>
                                      </tfoot>
                                  </table>
                              </div>
                          </div>
                      </div>
                      @endif
                  </div>
                </div>
              </div>
          </div>
        <!-- /.content-wrapper -->


@stop
