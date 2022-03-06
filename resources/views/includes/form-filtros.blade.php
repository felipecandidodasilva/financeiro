@isset($dadosPagina['rotaFiltros'])
    <div class="row">
        <div class="col-sm-12">
            <form action=" {{ route($dadosPagina['rotaFiltros']) }} "  method="POST" class="form" >
                @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <label for="contaId">Conta:</label>
                            <select name="contaId" id="contaId" class="form-control">
                                <option value="0" @if (!isset($filtros['contaId'])) selected @endif>Todas</option>
                                @foreach ($contas as $c)
                                <option value="{{$c->id}}" @if (isset($filtros['contaId']) && $filtros['contaId'] == $c->id ) selected @endif>{{$c->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="categoriaId">Categoria:</label>
                            <select name="categoriaId" id="categoriaId" class="form-control">
                                <option value="0" @if (!isset($filtros['categoriaId'])) selected @endif> Todas</option>
                                @foreach ($categorias as $ca)
                                <option value="{{$ca->id}}" @if (isset($filtros['categoriaId']) && $filtros['categoriaId'] == $ca->id ) selected @endif>{{$ca->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                       
                        <div class="col-md-2">
                            <label for="dataIni">Início</label>
                            <input type="date" name='dataIni' id='dataIni' class="form-control" value="{{$filtros['dataIni']}}">
                        </div>
                        <div class="col-md-2">
                            <label for="dataFim">Fim</label>
                            <input type="date" name='dataFim' id='dataFim' class="form-control" value="{{$filtros['dataFim']}}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-sm btn-default"><i class="fa fa-search"aria-hidden="true"></i> Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <br>
        @endisset