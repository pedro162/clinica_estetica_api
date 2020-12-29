
@php $randId = rand(11111, 99999); @endphp
<div class="container-fluid">
	<div class="col-md-12 col-sm-12" style="">
        <form action="{{route('cobranca.receber.acertar.save', $ids)}}" method="post" class="form p-2" id="form_receber_acertar{{$randId}}">
            @csrf
            <div class="row">
                <div class="col-md-12 col-sm-12 " >
                    <fieldset class="row"><legend></legend>

                        <div class="form-group col-md-2 col-sm-12">
                            <label class="label" for="acao{{$randId}}">Ação</label>
                            <select id="acao{{$randId}}" name="acao" class="form-control form-control-sm" required="required" >
                                <option value="acertar">Acertar</option>
                                <option value="desdobrar">Desdobrar</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2 col-sm-12">
                            <label class="label" for="vrDuplicatas{{$randId}}">Valor das Duplicatas</label>
                            <input type="text" id="vrDuplicatas{{$randId}}" value="{{number_format($totalCobrancas, 2, ',', '.')}}" name="vrDuplicatas" class="form-control form-control-sm" required="required"  readonly>
                        </div>

                        <div class="form-group col-md-2 col-sm-12">
                            <label class="label" for="vrDescontos{{$randId}}">Descontos</label>
                            <input type="text" id="vrDescontos{{$randId}}" name="vrDescontos" class="form-control form-control-sm" required="required"  minlength="3" maxlength="255">
                        </div>

                        <div class="form-group col-md-2 col-sm-12">
                            <label class="label" for="vrCreditoCliente{{$randId}}">Acréscimos (Crédito de Cliente)</label>
                            <input type="text" id="vrCreditoCliente{{$randId}}" name="vrCreditoCliente" class="form-control form-control-sm" required="required">
                        </div>

                        
                        <div class="form-group col-md-2 col-sm-12">
                            <label class="label" for="vrJuros{{$randId}}">Juros</label>
                            <input type="text" id="vrJuros{{$randId}}" value="{{number_format($totalJuros, 2, ',', '.')}}" name="vrJuros" class="form-control form-control-sm">
                        </div>
                        

                        <div class="form-group col-md-2 col-sm-12">
                            <label class="label" for="vrMultas{{$randId}}">Multas</label>
                            <input type="text" id="vrMultas{{$randId}}" name="vrMultas" value="{{number_format($totalMultas, 2, ',', '.')}}" class="form-control form-control-sm">
                        </div>


                        <div class="form-group col-md-6 col-sm-12">
                            <label class="label" for="vrFinal{{$randId}}">Valor Final</label>
                            <input type="text" id="vrFinal{{$randId}}" value="{{number_format($totalCobrancas + $totalJuros + $totalMultas, 2, ',', '.')}}" name="vrFinal" class="form-control form-control-sm" readonly>
                        </div>

                        
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="label" for="vrDiferenca{{$randId}}">Diferença</label>
                            <input type="text" id="vrDiferenca{{$randId}}" name="vrDiferenca" class="form-control form-control-sm"  readonly>
                        </div>

                    </fieldset>

                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <hr/>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12">

                    <fieldset class="row"><legend></legend>
                            <div class="col-md-6 col-sm-12">
                                <div class="row">
                                    <div class="form-group col-md-3 col-sm-12">
                                        <label class="label" for="forma_id{{$randId}}">Forma de Pagamento</label>
                                        <select id="forma_id{{$randId}}" name="forma_id" class="form-control form-control-sm">
                                            @foreach($foramasPagamento as $forma)
                                                <option value="{{$forma->id}}">{{$forma->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    
                                    <div class="form-group col-md-3 col-sm-12">
                                        <label class="label" for="vr{{$randId}}">Valor</label>
                                        <input type="text" id="vr{{$randId}}" name="vr" value="{{number_format($totalCobrancas + $totalJuros + $totalMultas, 2, ',', '.')}}" class="form-control form-control-sm">
                                    </div>
                                    

                                    <div class="form-group col-md-3 col-sm-12">
                                        <label class="label" for="plano_id{{$randId}}">Plano de Pagamento</label>
                                        <input type="date" id="plano_id{{$randId}}" name="plano_id" class="form-control form-control-sm">
                                    </div>


                                    <div class="form-group col-md-3 col-sm-12">
                                        <label class="label" for="operador_id{{$randId}}">Operador Financeiro</label>
                                        <input type="text" id="operador_id{{$randId}}" name="operador_id" class="form-control form-control-sm" >
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-3 col-sm-12">
                                        <label class="label" for="doc{{$randId}}">Doc</label>
                                        <input type="techebox" id="doc{{$randId}}" name="doc"  >
                                    </div>

                                    
                                    <div class="form-group col-md-3 col-sm-12" style="visibility: hidden" >
                                        <label class="label" for="useData{{$randId}}"><br/></label>
                                        <input type="techebox" id="useData{{$randId}}" name="useData"  >
                                    </div>
                                    

                                    <div class="form-group col-md-3 col-sm-12" style="visibility: hidden">
                                        <label class="label" for="plano_id{{$randId}}">Plano de Pagamento</label>
                                        <input type="date" id="plano_id{{$randId}}" name="plano_id" class="form-control form-control-sm">
                                    </div>


                                    <div class="form-group col-md-3 col-sm-12">
                                        <br/>
                                        <button type="button" class="btn btn-sm btn-outline-primary" style=""><i class="fa fa-plus"></i> Acertar /  Desdobrar</button>
                                    </div>

                                </div>

                            </div>
                            
                            <div class="col-md-6 col-sm-12 " style="max-height: 500px; overflow-y: scroll;">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <table class="table table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th>COB</th>
                                                    <th>DOCUMENTO</th>
                                                    <th>VALOR</th>
                                                    <th>VENCIMENTO</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-ms-12 mt-5" style="text-align: right">
                                        <button class="btn btn-sm btn-outline-primary" style=""><i class="fa fa-check"></i> Concluir</button>
                                    </div>                                
                                </div>
                            </div>
                    </fieldset>
                </div>
            </div>
        </form>
	</div>
</div>
