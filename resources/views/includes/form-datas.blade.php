    <form action=" {{ route('periodo')}}"  method="POST" class="form-inline" >
        @csrf
            <div class="col-xs-4 col-sm-3">
                <input type="date" name='dataIni' id='dataIni' class="form-control" value="{{session('dataIni', date('Y-m-01'))}}">
            </div>
            <div class="col-xs-4 col-sm-3">
                <input type="date" name='dataFim' id='dataFim' class="form-control" value="{{session('dataFim', date('Y-m-t'))}}">
            </div>
            <div class="col-xs-2">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"
                    aria-hidden="true"></i></button>
                </div>
    </form>