<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$dadosPagina['titulo']}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Conta</th>
                            <th>Pagas</th>
                            <th>A Pagar</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dados as $d)
                            @php
                                $tPagas =  isset($tPagas) ? $tPagas : 0;
                                $tAPagar =  isset($tAPagar) ? $tAPagar : 0;
                                $paga = (float)\App\Model\Saida::totalPorPeriodo(true,'categoria_id',$d->id);
                                $apagar =(float) \App\Model\Saida::totalPorPeriodo(false,'categoria_id',$d->id);
                                $tPagas += $paga;
                                $tAPagar += $apagar;
                            @endphp
                            <tr>
                                <td>{{$d->nome}}</td>
                                <td>{{ number_format($paga,2,",",".") }}</td>
                                <td>{{ number_format($apagar,2,",",".") }}</td>
                                <td>{{ number_format($d->total,2,",",".") }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Totais</td>
                            <td>{{ number_format($tPagas,2,",",".") }}</td>
                            <td>{{ number_format($tAPagar,2,",",".") }}</td>
                            <td>{{ number_format($tAPagar + $tPagas,2,",",".") }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div> <!-- box-body table-responsive -->
        </div>
    </div>
</div>
    </div>
    <div class="col-md-12">
    <h5 class="alert {{$dadosPagina['alert-rodape']}}">Total de {{$dadosPagina['titulo']}} {{ number_format($dadosPagina['restaPagar'],2,",",".") }}</h5>
    </div>
</div>