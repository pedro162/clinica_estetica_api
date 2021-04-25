
@php $randId = rand(11111, 99999); @endphp
<div class="container-fluid">
	<div class="col-md-12 col-sm-12" style="">
        <form action="{{route('cobranca.receber.acertar.save', $ids)}}" method="post" class="form p-2" id="form_receber_acertar{{$randId}}">
            @csrf
            <div class="row">
                <div class="col-md-12 col-sm-12 " >
                    <div class="row">
                        <div class="col-md-12 col-sm-12" style="text-align: right;">
                            <button id="duplicatas{{$randId}}" class="btn btn-sm btn-outline-primary" style="border-radius: 20px;" ><b>Duplicatas</b></button>
                        </div>
                    </div>
                    <div class="row"><legend></legend>

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

                        <div class="form-group col-md-3 col-sm-12">
                            <label class="label" for="rca{{$randId}}">RCA</label>
                            <select id="rca{{$randId}}" name="rca" class="form-control form-control-sm">
                            <option value=""></option>
                                @foreach($rcas as $rc)
                                    <option value="{{$rc->id}}">{{$rc->name}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group col-md-4 col-sm-12">
                            <label class="label" for="vrFinal{{$randId}}">Valor Final</label>
                            <input type="text" id="vrFinal{{$randId}}" value="{{number_format($totalCobrancas + $totalJuros + $totalMultas, 2, ',', '.')}}" name="vrFinal" class="form-control form-control-sm" readonly>
                        </div>

                        
                        <div class="form-group col-md-4 col-sm-12">
                            <label class="label" for="vrDiferenca{{$randId}}">Diferença</label>
                            <input type="text" id="vrDiferenca{{$randId}}" name="vrDiferenca" class="form-control form-control-sm"  readonly>
                        </div>

                    </div>

                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <hr/>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12">

                    <div class="row"><legend></legend>
                            <div class="col-md-6 col-sm-12">
                                <div class="row">
                                    <div class="form-group col-md-3 col-sm-12">
                                        <label class="label" for="forma_id{{$randId}}">Forma de Pagamento</label>
                                        <select id="forma_id{{$randId}}" name="forma_id" class="form-control form-control-sm">
                                        <option value=""></option>
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
                                        <select id="plano_id{{$randId}}" name="plano_id" class="form-control form-control-sm">
                                        
                                        </select>
                                    </div>


                                    <div class="form-group col-md-3 col-sm-12">
                                        <label class="label" for="operador_id{{$randId}}">Operador Financeiro</label>
                                        <select  id="operador_id{{$randId}}" name="operador_id" class="form-control form-control-sm">
                                        
                                        </select>
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
                                        <button type="button" id="btn-cob{{$randId}}" class="btn btn-sm btn-outline-primary" style=""><i class="fa fa-plus"></i> Acertar /  Desdobrar</button>
                                    </div>

                                </div>

                            </div>
                            
                            <div class="col-md-6 col-sm-12 " style="max-height: 500px; overflow-y: scroll;" id="areaDesdobramento{{$randId}}">
                                @csrf
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

                                            <tbody id="tbodyCob{{$randId}}">
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-ms-12 mt-5" style="text-align: right">
                                        <button class="btn btn-sm btn-outline-primary" id="concluir{{$randId}}" style=""><i class="fa fa-check"></i> Concluir</button>
                                    </div>                                
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </form>
	</div>
</div>

<script>

    const objTable = new Utilitarios();
	objTable.setTableInputs($('#tbodyCob{{$randId}}'));

    $('#vr{{$randId}}, #vrDiferenca{{$randId}}, #vrFinal{{$randId}}, #vrMultas{{$randId}}, #vrJuros{{$randId}}, #vrCreditoCliente{{$randId}}, #vrDescontos{{$randId}}, #vrDuplicatas{{$randId}} ').mask('#.##0,00', {reverse: true})
    
    $('html body').find('#duplicatas{{$randId}}').on('click', function(ev){
        ev.preventDefault()
        let token = $('html body #form_receber_acertar{{$randId}}').find('input[name="_token"]:first-child').val()
        let duplicatas = "{{$ids}}";

        let formData = new FormData()
        formData.append('ids', duplicatas)
        formData.append('_token', token)

        $.ajax({
            url: '/cobranca/receber/index',
            type: 'POST',
            data: formData,
            dataType: 'HTML',
            processData:false,
            contentType: false,
            success: function(response){
                Utilitarios.assistenteModal(response, 'lg', 'Duplicatas', '900px')
            },
            error:function(response, status, error){
				//console.log(response, status, error)
				console.log(response);
				let errors = response.responseJSON;
				let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';

				if(errors.mensagem){
					let erros = errors.mensagem;
					console.log(erros);
					msg+=erros+'<br/>';
				}
				Utilitarios.assistenteMensageAlert(msg, 'warning');
			}
        })
    })

    //------------- salva os acertos/desdobramentos

    $('html body').find('#concluir{{$randId}}').on('click', function(ev){
        ev.preventDefault();
        ev.stopPropagation();

        let token       = $('html body #form_receber_acertar{{$randId}}').find('input[name="_token"]:first-child').val()
        let duplicatas  = "{{$ids}}";
        let acao 		= $('html body').find('#acao{{$randId}}').val();
        let rca        = $('html body').find('#rca{{$randId}}').val();

        let formData = new FormData()
        formData.append('ids', duplicatas)
        formData.append('_token', token)
        formData.append('tpAcao', acao);
        formData.append('rca', rca);
        let destino = objTable.getDataTable();

        if(Array.isArray(destino)){
            for(let i = 0; !(i ==destino.length); i++){
                for(vl in destino[i]){
                    
                    formData.append('destinos['+i+']['+vl+']', destino[i][vl])
                } 
            }
        }
      

        

        $.ajax({
            url: '/cobranca/receber/acertar/save/'+duplicatas,
            type: 'POST',
            data: formData,
            dataType: 'HTML',
            processData:false,
            contentType: false,
            success: function(response){
                Utilitarios.assistenteModal(response, 'lg', 'Duplicatas', '900px')
            },
            error:function(response, status, error){
				//console.log(response, status, error)
				console.log(response);
				let errors = response.responseJSON;
				let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';

				if(errors.mensagem){
					let erros = errors.mensagem;
					console.log(erros);
					msg+=erros+'<br/>';
				}
				Utilitarios.assistenteMensageAlert(msg, 'warning');
			}
        })
    })

    $('html body').find('#btn-cob{{$randId}}').on('click', function(ev){

        try{

            let form = $('#form_receber_acertar{{$randId}}');
                
            let valor 			= form.find('#vr{{$randId}}').val();
            let formPgto 		= form.find('#forma_id{{$randId}}').val();
            let formPgtoText	= form.find('#forma_id{{$randId}}').find('option[value='+formPgto+']').text();
            let planoPgto 		= form.find('#plano_id{{$randId}}').val();
            let planoPgtoText	= form.find('#plano_id{{$randId}}').find('option[value='+planoPgto+']').text();
            let operadorFinan 	= form.find('#operador_id{{$randId}}').val();
            let operFiText 		= form.find('#operador_id{{$randId}}').find('option[value='+operadorFinan+']').text();
            let cvNsu 			= form.find('#doc{{$randId}}').val();			
            let vrLiquido 		= $('html body').find('#vrLiquido{{$randId}}').val();	
            let acao 		    = $('html body').find('#acao{{$randId}}').val();	
            let token           = form.find('#areaDesdobramento{{$randId}}').find('[name="_token"]').val();
            vrLiquido 			= Utilitarios.foramtCalcCod(vrLiquido)
            console.log('Valor vr: '+valor)


            console.log('Saldo cob: '+ saldo(objTable))
            let sald = saldo(objTable);
            console.log('Valor formatado: '+sald)
            //---- validar cobraça
            let errors = validarCobranca(valor, formPgto, planoPgto, operadorFinan, cvNsu, sald)
            if(Array.isArray(errors) && (errors.length > 0)){
            
                alert('Atenção, os seguintes erros foram encontrados: '+errors.join('\n'))
                return false;
            }
            //-----------------

            let url = '/cobranca/receber/simular/desdobramento/{{$ids}}';
            let formData = new FormData();
            formData.append('destinos[idPessoa]', '{{ $idPessoa }}');
            formData.append('destinos[forma_pagamento_id]', formPgto);
            formData.append('destinos[op_finan_id]', operadorFinan);
            formData.append('destinos[dtVencimento]', null);
            formData.append('destinos[vrCobranca]', valor);
            //formData.append('destinos[idCobrancaTipo]', formPgto);
            formData.append('destinos[pl_pgto_id]', planoPgto);
            formData.append('destinos[cvNsu]', cvNsu);
            //formData.append('destinos[idPlanoContaSubConta]', '1');
            //formData.append('destinos[qtdParcelas]', '1');
            formData.append('destinos[filial_id]', '{{$idFilial}}'); 
            formData.append('destinos[tpAcao]', acao);
            formData.append('_token', token); 

            simularDesdobramento(formData, url, type='POST', dataType = 'JSON');

        }catch(ex){
            console.log(ex.message)
        }

    })

    function adicionarDestino(objTable, dados={}){
        let data = {formPgtoText: dados.formPgtoText , cvNsu: dados.cvNsu , valor: dados.valor, dtVencimento: dados.dtVencimento, formPgto: dados.formPgto, planoPgto: dados.planoPgto, operadorFinan: dados.operadorFinan}
        
        let retorno = objTable.adicionaFielsTable(data);
        console.log('Tabela--------------------------')
        console.log(retorno);
        console.log('Tabela--------------------------')	
        
        objTable.retornaFieldsTable(['formPgtoText', 'cvNsu', 'valor', 'dtVencimento']);

        let totCobAdd 	= totalCobAdd(objTable, 'valor');	
        let vrSaldo 	= saldo(objTable);
        console.log('saldo: '+vrSaldo);

        let form = $('#form_receber_acertar{{$randId}}');
        form.find('#vrSaldo{{$randId}}').val(Utilitarios.formatMoney(vrSaldo));

        $('html body').find('#divCob{{$randId}}').scrollTop($('#divCob{{$randId}}').height() ** 3)

        if(vrSaldo <= 0){
            $('html body').find('#vrDesconto{{$randId}}').attr('readonly', 'readonly')
        }
        vrSaldo = Utilitarios.formatMoney(vrSaldo)
        $('html body').find('#vrDiferenca{{$randId}}').val(vrSaldo)
        $('html body').find('#vr{{$randId}}').val(vrSaldo)
        
        //alert('aqui')
    }



    function acertarDescobrar(){

    }

    $('html body').find('#forma_id{{$randId}}').on('change', function(ev){
        let formData = new FormData();

        let idFormaPgto = $(this).val();
        let token = $('html body').find('#areaDesdobramento{{$randId}}').find('input[name="_token"]').val();

        if(! token.trim().length > 0){
            return false;
        }

        idFormaPgto = Number(idFormaPgto);
        if(isNaN(idFormaPgto)){
            return false;
        }

        formData.append('_token', token);
        formData.append('forma_pagamentos_id', idFormaPgto);
        carregarPlanoPagamento(formData);
        carregarOperadorFinanceiro(formData);
    })


    function carregarPlanoPagamento(formData){
        let url = '/forma_pagamento/plano/pagamento/json';
        let type = 'POST';
        let dataType = 'JSON';

        $.ajax({
            url: url,
            type: type,
            data: formData,
            dataType: dataType,
			processData:false,
			contentType:false,
            success: function(response){
                console.log(response)
                let data = response.data
                let opstions = '';
                if(Array.isArray(data) && (data.length > 0)){
                    
                    for(let i=0; !(i == data.length); i++){
                        opstions+= `<option value="${data[i].id}">${data[i].name +' '+data[i].descricao }</option>`;
                    }

                }
                $('html body').find('#plano_id{{$randId}}').html(opstions);
            },
            error:function(response, status, error){
				//console.log(response, status, error)
				console.log(response);
				let errors = response.responseJSON;
				let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';

				if(errors.mensagem){
					let erros = errors.mensagem;
					console.log(erros);
					msg+=erros+'<br/>';
				}
				Utilitarios.assistenteMensageAlert(msg, 'warning');
			}
        })
    }


    function carregarOperadorFinanceiro(formData){
        let url = '/forma_pagamento/operador/financeiro/json';
        let type = 'POST';
        let dataType = 'JSON';

        $.ajax({
            url: url,
            type: type,
            data: formData,
            dataType: dataType,
			processData:false,
			contentType:false,
            success: function(response){
                console.log(response)
                let data = response.data
                let opstions = '';
                if(Array.isArray(data) && (data.length > 0)){
                    
                    for(let i=0; !(i == data.length); i++){
                        opstions+= `<option value="${data[i].id}">${data[i].pessoa.name}</option>`;
                    }
                }

                $('html body').find('#operador_id{{$randId}}').html(opstions);

            },
            error:function(response, status, error){
				//console.log(response, status, error)
				console.log(response);
				let errors = response.responseJSON;
				let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';

				if(errors.mensagem){
					let erros = errors.mensagem;
					console.log(erros);
					msg+=erros+'<br/>';
				}
				Utilitarios.assistenteMensageAlert(msg, 'warning');
			}
        })
    }
    

    function simularDesdobramento(formData, url, type='POST', dataType = 'JSON'){
       // let url = '/cobranca/receber/simular/desdobramento/{idReferencia}';
        $.ajax({
            url: url,
            type: type,
            data: formData,
            dataType: dataType,
			processData:false,
			contentType:false,
            success: function(response){
                console.log('response----------------')
                console.log(response)
                console.log('response----------------')
                let data = response.data;
                
                console.log(data)
                if(Array.isArray(data) && (data.length > 0)){
                    for(let i =0; !(i == data.length); i++){
                        let nsu = data[i].nrDoc ? data[i].nrDoc : '';
                        let operadorFinan = data[i].op_finan_id ? data[i].op_finan_id : '';
                        let dtVencimento = data[i].dtVencimentoCobrancaReceber ? data[i].dtVencimentoCobrancaReceber: '';
                        let planoPagamento = data[i].pl_pgto_id ? data[i].pl_pgto_id : '';
                        let formaPagamento = data[i].forma_pagamento_id ? data[i].forma_pagamento_id : '';
                        let vrCobranca = data[i].vrBruto ? data[i].vrBruto : '';
                        let formaPagamentoTex = data[i].formPgtoText.trim().length > 0 ? data[i].formPgtoText : '';

                        let dados={valor: vrCobranca, formPgtoText: formaPagamentoTex, formPgto: formaPagamento, planoPgto: planoPagamento, dtVencimento: dtVencimento, operadorFinan:operadorFinan , cvNsu:nsu }
                        console.log('dados----------------')
                        console.log(dados)
                        console.log('dados----------------')
                        adicionarDestino(objTable, dados)
                        
                        
                    }
                }

            },
            error:function(response, status, error){
				//console.log(response, status, error)
				console.log(response);
				let errors = response.responseJSON;
				let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';

				if(errors.errors){
					let erros = errors.errors.error;
					console.log(erros);
					msg+=erros+'<br/>';
				}
				Utilitarios.assistenteMensageAlert(msg, 'warning');
			}
        })
    }


    //----- remove um item da tabela
	$('html body').find('table tbody#tbodyCob{{$randId}}').delegate('tr td:last-child button', 'click', function(ev){
		try{

			let id = $(this).attr('id');
			objTable.removeFieldsTable(id)

			let vrTotal 	= $('html body').find('#vrBruto{{$randId}}').val();
			let vrDesconto	= $('html body').find('#vrDesconto{{$randId}}').val();
			vrTotal 		= Utilitarios.foramtCalcCod(vrTotal)
			vrDesconto 		= Utilitarios.foramtCalcCod(vrDesconto)

			let totCobAdd 	= totalCobAdd(objTable, 'valor');	

			let vrLiquido 	= adicionarDesconto(vrTotal,vrDesconto,totCobAdd);

			let vrSaldo = saldo(objTable);
			$('#vrSaldo{{$randId}}').val(Utilitarios.formatMoney(vrSaldo));
			if(vrSaldo > 0){
				$('html body').find('#vrDesconto{{$randId}}').removeAttr('readonly')
			}

		}catch(e){
			console.log(e.message)
		}
		
	})

    //#, , , , , , #vrDescontos{{$randId}}, #vrDuplicatas{{$randId}}

	$('html body').delegate('#vrDescontos{{$randId}}, #vrDiferenca{{$randId}} , #vrFinal{{$randId}}, #vrMultas{{$randId}}, #vrJuros{{$randId}}, #vrCreditoCliente{{$randId}} ', 'change', function(){
		try{
             
			let result = calculaTotalComDescontoAcrescimos();

		}catch(e){
			console.log(e.message)
		}

	})



	function validarCobranca(valor, formaPgto, planoPgto, operadorFinan, cvNsuDoc, saldo){
        console.log('Saldo afaf: '+saldo)
        console.log('Valor gasgsg: '+valor)
		valor 		= Number(Utilitarios.foramtCalcCod(valor)).toFixed(2);
		saldo 		= Number(Utilitarios.foramtCalcCod(saldo)).toFixed(2);
		
		let errors 	= [];
		if(saldo < 0){
			errors.push('Não há mais cobrancas para serem adicionadas, '+saldo);

		}else{

			if(valor <= 0){
				errors.push('Valor inválido');
			}else if(Number(valor) > Number(saldo)){
				errors.push('O valor da cobrança não pode ser maior que o saldo');
			}

            if(
                ! ((!isNaN(formaPgto)) && (formaPgto > 0) )
            ){
                errors.push('Forma de pagamento inválida');
            }

            if(
                ! ((!isNaN(planoPgto)) && (planoPgto > 0) )
            ){
                errors.push('Plano de pagamento inválida');
            }

           
			if(cvNsuDoc.trim().length == 0){
				//errors.push('CV, NSU ou DOC inválido');
			}

			
		}


		return errors;
	}

	function saldo(objTable){
		let vrTotCob 	= totalCobAdd(objTable, 'valor')
		let valor 		= Utilitarios.foramtCalcCod(calculaTotalComDescontoAcrescimos());

        console.log('vrTotCob: '+vrTotCob)
        console.log('valor: '+valor)

		let result 	= Number(valor) - Number(vrTotCob);

		/*if(result < 0){
			return 0;
		}*/
		
		return Number(result).toFixed(2);
	}

    function calculaTotalComDescontoAcrescimos(){
        let acao                = $("#acao{{$randId}}").val(); 
        let vrDuplicatas        = $("#vrDuplicatas{{$randId}}").val();
        let vrDescontos         = $("#vrDescontos{{$randId}}").val();
        let vrJuros             = $("#vrJuros{{$randId}}").val();
        let vrMultas            = $("#vrMultas{{$randId}}").val();
        let vrCreditoCliente    = $("#vrCreditoCliente{{$randId}}").val();
        let vrFinal             = $("#vrFinal{{$randId}}");

        vrDuplicatas        = Utilitarios.foramtCalcCod(vrDuplicatas);
        vrDescontos         = Utilitarios.foramtCalcCod(vrDescontos);
        vrJuros             = Utilitarios.foramtCalcCod(vrJuros);
        vrMultas            = Utilitarios.foramtCalcCod(vrMultas);
        vrCreditoCliente    = Utilitarios.foramtCalcCod(vrCreditoCliente);

        if((vrDescontos > 0) && (vrCreditoCliente > 0)){
            alert('Não é possível atriuir descontos e crédotos de forma simultânea.')
            return 0;
        }
        
        if(acao.trim().toLowerCase() == 'acertar'){
           
            let valorFinal = (vrDuplicatas + vrCreditoCliente)- vrDescontos;
            vrFinal.val(Utilitarios.formatMoney(valorFinal))
            return Utilitarios.foramtCalcCod(valorFinal);

        }else if(acao.trim().toLowerCase() == 'desdobrar'){

            let valorFinal = (vrDuplicatas + vrJuros + vrMultas ) - vrDescontos;
            vrFinal.val(Utilitarios.formatMoney(valorFinal))
            return Utilitarios.foramtCalcCod(valorFinal);

        }else{
            alert('Ação inválida.')
            return 0;
        }

    }

	function totalCobAdd(objTable, index){
		let data = objTable.getDataTable();
		console.log(data);
		let vrTotal = 0;
		if(Array.isArray(data)){
			
			for(let i=0; !(i == data.length); i++){
				if(data[i] != null){
					if(data[i].hasOwnProperty(index)){
						vrTotal += Number(Utilitarios.foramtCalcCod(data[i][index]))
						
					}
				}
			}
		}

		return Number(vrTotal).toFixed(2);
	}

	function adicionarDesconto(vrTotal,vrDesconto,totCobAdd){
		
		vrTotal 		= Utilitarios.foramtCalcCod(vrTotal);
		vrDesconto 		= Utilitarios.foramtCalcCod(vrDesconto)
		totCobAdd 		= Utilitarios.foramtCalcCod(totCobAdd)
		vrTotal 		= Number(vrTotal);
		vrDesconto 		= Number(vrDesconto);
		totCobAdd 		= Number(totCobAdd);
		console.log('tota: '+vrTotal)
		console.log('desconto: '+vrDesconto)
		
		if(vrDesconto > (vrTotal - totCobAdd)){
			$('html body').find('#vrDesconto{{$randId}}').val('');
			
			return 0;
		}	
		let vrFinal	   	= vrTotal - vrDesconto;
		vrFinal = vrFinal.toFixed(2);

		return vrFinal;
	}
    
</script>
