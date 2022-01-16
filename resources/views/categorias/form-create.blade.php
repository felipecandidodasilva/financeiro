<div class="col-xs-12 col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2>Criar Nova Categoria </h2>
            </div>
           
            <div class="box-body" >
              
                <form action="{{ route('categoria.store')  }}" method="post">
                        {!! csrf_field() !!}
        <div class="form-group has-feedback {{ $errors->has('nome') ? 'has-error' : '' }}">
            <label for="nome">Nome Categoria</label>    
            <input type="text" name="nome" class="form-control" value="{{ old('nome') }}">
                    @if ($errors->has('nome'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nome') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('tipo') ? 'has-error' : '' }}">
                    <label for="nome">Tipo de Categoria</label>
                    <select name="tipo" id="tipo" class="form-control" >
                        <option value="E">Entrada</option>
                        <option value="S">Saída</option>
                    </select>
                       
                        @if ($errors->has('tipo'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tipo') }}</strong>
                        </span>
                        @endif
                    </div>
            <button type="submit"
            class="btn btn-primary btn-block btn-flat"
            >Salvar</button>
        </form>
    </div>
</div>
</div>