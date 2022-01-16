<div class="row">
  <div class="col-xs-12 col-md-3">
    <h4 style="margin-top: 0;">
    {{$dadosPagina['titulo']}}                
    </h4>
  </div>
</div>
<ol class="breadcrumb">
  <li><a href="/home">Início</a></li>
  @foreach ($dadosPagina['caminhos'] as $caminho)
  <li><a href="{{ $caminho['rota'] }}">{{ $caminho['descricao']}}</a></li>
@endforeach
</ol>