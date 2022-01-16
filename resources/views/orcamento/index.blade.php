@extends('adminlte::page')

@section('title', $dadosPagina['titulo'])

@section('content_header')
@include('includes.headerPages')
            
@stop
@section('content')
       
  <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <th>Data</th>
                <th>Referência</th>
                <th>Pessoa</th>
                <th>Título</th>
                <th>Status</th>
                <th>Opções</th>
              </thead>
              <tbody>
                <tr>
                  <td>01/09/2020</td>
                  <td>01/2020</td>
                  <td>Felipe Cândido</td>
                  <td>Reforma Elétrica Casa</td>
                  <td>Enviado</td>
                  <td>Editar</td>
                </tr>
              </tbody>
            </table>
          </div>

        </div> <!-- box box-primary -->
      </div>
  </div>
    
@stop


