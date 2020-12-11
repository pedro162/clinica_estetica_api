
@php $randId = rand(11111, 99999); @endphp

<div class="container-fluid">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('cobranca.receber.mensalidade.store', $registro->id)}}" method="post" class="form  p-2" id="form_pessoa_cadastrar{{$randId}}">
				@csrf
				<div class="row">
					<div class="form-group col-md-4 col-sm-12">
						<label class="label label-sm" for="pessoa{{$randId}}">Cliente</label>
						<input type="text" id="pessoa{{$randId}}" name="pessoa" class="form-control form-control-sm" value="{{ ucwords($registro->name.' '.$registro->name_opcional)}}" readonly="readonly">
					</div>

					<div class="form-group col-md-4 col-sm-12">
						<label class="label label-sm" for="vendedor{{$randId}}">Vendedor</label>
						<select id="vendedor{{$randId}}" name="vendedor" class="form-control form-control-sm" required="required">
							<option value="1">José Pedro Aguiar Ferreira</option>
							<option value="2">Luciana Ramos Saraiva</option>
						</select>
					</div>

					<div class="form-group col-md-4 col-sm-12">
						<label class="label label-sm" for="pessoa{{$randId}}">Referência</label>
						<input type="text" id="pessoa{{$randId}}" name="pessoa" class="form-control form-control-sm" value="{{ ucwords('Mensalidade Academia')}}" readonly="readonly">
					</div>
					
				</div>
				<div class="row mb-5">
					<div class="form-group col-md-4 col-sm-12">
						<label class="label label-sm" for="vrBruto{{$randId}}">Valor Bruto</label>
						<input type="text" id="vrBruto{{$randId}}" name="vrBruto" class="form-control form-control-sm" readonly="readonly" value="200,00">
					</div>

					<div class="form-group col-md-4 col-sm-12">
						<label class="label label-sm" for="vrLiquido{{$randId}}">Valor Líquido</label>
						<input type="text" id="vrLiquido{{$randId}}" name="vrLiquido" class="form-control form-control-sm" readonly="readonly" value="200,00">
					</div>

					<div class="form-group col-md-4 col-sm-12">
						<label class="label label-sm" for="vrDesconto{{$randId}}">Desconto</label>
						<input type="text" id="vrDesconto{{$randId}}" name="vrDesconto" class="form-control form-control-sm">
					</div>
					
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<fieldset class="row"><legend></legend>
							<div class="form-group col-md-3 col-sm-12">
								<label class="label label-sm" for="vrCobranca{{$randId}}">Valor</label>
								<input type="text" id="vrCobranca{{$randId}}" name="vrCobranca" class="form-control form-control-sm" required="required">
							</div>

							<div class="form-group col-md-3 col-sm-12">
								<label class="label label-sm" for="vrSaldo{{$randId}}">Saldo</label>
								<input type="text" id="vrSaldo{{$randId}}" name="vrSaldo" class="form-control form-control-sm" readonly="readonly" value="200,00">
							</div>

							<div class="form-group col-md-3 col-sm-12">
								<label class="label label-sm" for="forma_pagamento{{$randId}}">Forma Pagamento</label>
								<select id="forma_pagamento{{$randId}}" name="forma_pagamento" class="form-control form-control-sm" required="required">
									<option></option>
									@foreach($formaPagamento as $forma)
									<option value="{{$forma->id}}" cdCobrancaTipo="{{$forma->cdCobrancaTipo}}">{{ucwords($forma->name)}}</option>
									@endforeach
								</select>
							</div>


							<div class="form-group col-md-3 col-sm-12" >
								<label class="label label-sm" for="palano_pagamento{{$randId}}">Plano Pagamento</label>
								<select id="palano_pagamento{{$randId}}" name="palano_pagamento" class="form-control form-control-sm" required="required">
									<option ></option>
									@foreach($planoPagamento as $val)
										<option value="{{$val->id}}">{{$val->name}}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group col-md-3 col-sm-12">
								<label class="label label-sm" for="operador_financeiro{{$randId}}">Operador Financeiro</label>
								<select id="operador_financeiro{{$randId}}" name="operador_financeiro" class="form-control form-control-sm" required="required">
									<option ></option>
									@foreach($operadorFinanceiro as $val)
										<option value="{{$val->id}}">{{$val->pessoa->name}}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group col-md-3 col-sm-12">
								<label class="label" for="doc{{$randId}}">CV, NSU ou DOC</label>
								<input type="text" id="doc{{$randId}}" name="doc" class="form-control form-control-sm">
							</div>

							<div class="form-group col-md-6 col-sm-12">
								<button style="margin-top: 32px;" class="form-control form-control-sm btn btn-sm btn-outline-primary" type="button" id="btn-cob{{$randId}}" ><span><i class="fa fa-plus"></i></span> Adicionar Cobrança</button>
							</div>
						</fieldset>
					</div>

					<div id="divCob{{$randId}}" class="col-md-6 col-sm-12" style="max-height: 500px; overflow-y: scroll;">
						<h4>Cobrancas Adicionadas</h4>
						<table class="table table-sm table-responsive table-hover">
							<thead>
								<tr>
									<th>Valor</th>
									<th>Foram Pgamento</th>
									<th>Plano Pgamento</th>
									<th>Operador Financeiro</th>
									<th>CV, NSU ou DOC</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="tbodyCob{{$randId}}">
								
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 mt-4" align="center">
						<button style="float:right;" type="submit" class=" btn btn-sm btn-outline-primary"><span><i class="fa fa-plus"></i></span> Concluir</button>
					</div>
				</div>
			</form>
		</div>
	</div>	
</div>

<script type="text/javascript">
	//----- define mascaras para algusn campos
	$('#vrTotal{{$randId}}, #vrDesconto{{$randId}}, #vrCobranca{{$randId}}').mask('#.##0,00', {reverse: true})
	


	const objTable = new Utilitarios();
	objTable.setTableInputs($('#tbodyCob{{$randId}}'));
	//----- adicioa itens à tabela
	$('html body').delegate('#btn-cob{{$randId}}', 'click', function(ev){
		try{

			let form 			= $('#form_pessoa_cadastrar{{$randId}}');
			let valor 			= form.find('#vrCobranca{{$randId}}').val();
			let formPgto 		= form.find('#forma_pagamento{{$randId}}').val();
			let formPgtoText	= form.find('#forma_pagamento{{$randId}}').find('option[value='+formPgto+']').text();
			let planoPgto 		= form.find('#palano_pagamento{{$randId}}').val();
			let planoPgtoText	= form.find('#palano_pagamento{{$randId}}').find('option[value='+planoPgto+']').text();
			let operadorFinan 	= form.find('#operador_financeiro{{$randId}}').val();
			let operFiText 		= form.find('#operador_financeiro{{$randId}}').find('option[value='+operadorFinan+']').text();
			let cvNsu 			= form.find('#doc{{$randId}}').val();			
			let vrLiquido 		= $('html body').find('#vrLiquido{{$randId}}').val();	
			vrLiquido 			= Utilitarios.foramtCalcCod(vrLiquido)

			console.log('valor: '+valor)
			let data = {valor:valor, formPgtoText:formPgtoText, formPgto:formPgto, planoPgtoText:planoPgtoText, planoPgto:planoPgto, operFiText:operFiText, operadorFinan:operadorFinan, cvNsu:cvNsu };

			let errors = validarCobranca(valor, formPgto, planoPgto, operadorFinan, cvNsu, saldo(objTable, vrLiquido))

			if(errors.length > 0){
				alert('Atenção, os seguintes erros foram encontrados: \n\n'+errors.join('\n\n'));
				return false;
			}

			objTable.adicionaFielsTable(data);		
			objTable.retornaFieldsTable(['valor', 'formPgtoText' , 'planoPgtoText', 'operFiText', 'cvNsu']);

			let totCobAdd 	= totalCobAdd(objTable, 'valor');	
			let vrSaldo 	= saldo(objTable, vrLiquido);
			console.log('saldo: '+vrSaldo);
			form.find('#vrSaldo{{$randId}}').val(Utilitarios.formatMoney(vrSaldo));

			$('html body').find('#divCob{{$randId}}').scrollTop($('#divCob{{$randId}}').height() ** 3)

			if(vrSaldo <= 0){
				$('html body').find('#vrDesconto{{$randId}}').attr('readonly', 'readonly')
			}

		}catch(e){
			console.log(e.message);
		}
	})


	$('html body').delegate('#form_pessoa_cadastrar{{$randId}}', 'submit', function(ev){
		ev.preventDefault();

		let url 	= $(this).attr('action');
		let id 		= $(this).attr('id');
		let element = $(this);

		let form = new FormData($(this)[0]);
		for(let i=0; !(i == objTable.getDataTable().length); i++){
			for(let prop in objTable.getDataTable()[i]){
				let vl = objTable.getDataTable()[i][prop];
				form.append('fields['+prop+'][]', vl);
			}

		}
		$.ajax({
			url:url,
			type:'POST',
			dataType:'json',
			data:form,
			processData:false,
			contentType:false,
			success:function(response){
				console.log(response);
				console.log(response.data.id);

				if(response.data.hasOwnProperty('id') || response.data > 0){

					Utilitarios.assistenteMensageAlert('Registro criado com sucesso', 'success');
					let urlRecibo = '/cobranca/receber/recibo/'+response.data.id+'/OrdemServico';

					$.ajax({
						url: urlRecibo,
						type:'GET',
						dataType: 'HTML',
						success: function(response){

							Utilitarios.assistenteModal(response, 'lg', 'Recibo', null)
						},
						error:function(response, status, error){
							Utilitarios.assistenteMensageAlertClear();

							console.log(response);return;
							let objErros = response.responseJSON.errors;
							let errors = response.responseJSON;
							let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';

							if(response.responseJSON.errors){
								for (let prop in objErros){
									msg+='<strong>'+prop+': </strong>'+objErros[prop]+'<br/>';
								}

							}else if(errors.mensagem){
								let erros = errors.mensagem;
								console.log(erros);
								for (let i=0; !(i == erros.length); i++){
									msg+=erros[i]+'<br/>';
								}
							}
							Utilitarios.assistenteMensageAlert(msg, 'warning');
						}	
					})
					
				}
			},
			error:function(response, status, error){
				//console.log(response, status, error)
				console.log(response);
				let objErros = response.responseJSON.errors;
				let errors = response.responseJSON;
				let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';

				if(response.responseJSON.errors){
					for (let prop in objErros){
						msg+='<strong>'+prop+': </strong>'+objErros[prop]+'<br/>';
					}

				}else if(errors.mensagem){
					let erros = errors.mensagem;
					console.log(erros);
					for (let i=0; !(i == erros.length); i++){
						msg+=erros[i]+'<br/>';
					}
				}
				Utilitarios.assistenteMensageAlert(msg, 'warning');
			}


		})
	})

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

			let vrSaldo = saldo(objTable, vrLiquido);
			$('#vrSaldo{{$randId}}').val(Utilitarios.formatMoney(vrSaldo));
			if(vrSaldo > 0){
				$('html body').find('#vrDesconto{{$randId}}').removeAttr('readonly')
			}

		}catch(e){
			console.log(e.message)
		}
		
	})

	$('html body').delegate('#vrDesconto{{$randId}}', 'change', function(){
		try{

			let vrTotal 	= $('html body').find('#vrBruto{{$randId}}').val();
			let vrDesconto	= $('html body').find('#vrDesconto{{$randId}}').val();
			vrTotal 		= Utilitarios.foramtCalcCod(vrTotal)
			vrDesconto 		= Utilitarios.foramtCalcCod(vrDesconto)

			let totCobAdd 	= totalCobAdd(objTable, 'valor');			
			let vrLiquido 	= adicionarDesconto(vrTotal,vrDesconto,totCobAdd)
			if(vrLiquido <= 0){
				
				return false;
			}
			let vrSaldo 	= saldo(objTable,vrLiquido);
			console.log(totCobAdd);
			console.log(vrLiquido);
			console.log(vrSaldo);
			
			$('html body').find('#vrLiquido{{$randId}}').val(Utilitarios.formatMoney(vrLiquido));
			$('#vrSaldo{{$randId}}').val(Utilitarios.formatMoney(vrSaldo));

		}catch(e){
			console.log(e.message)
		}

	})



	function validarCobranca(valor, formaPgto, planoPgto, operadorFinan, cvNsuDoc, saldo){

		valor 		= Number(Utilitarios.foramtCalcCod(valor)).toFixed(2);
		saldo 		= Number(Utilitarios.foramtCalcCod(saldo)).toFixed(2);
		console.log('valor: '+valor);
		console.log('saldo: '+saldo);
		
		let errors 	= [];
		if(saldo <= 0){
			errors.push('Não há mais cobrancas para serem adicionadas');

		}else{

			if(valor <= 0){
				errors.push('Valor inválido');
			}else if(Number(valor) > Number(saldo)){
				errors.push('O valor da cobrança não pode ser maior que o saldo');
			}

			if(cvNsuDoc.trim().length == 0){
				errors.push('CV, NSU ou DOC inválido');
			}

			
		}


		return errors;
	}

	function saldo(objTable, vrTotal){
		let vrTotCob 	= totalCobAdd(objTable, 'valor')
		vrTotal 		= Utilitarios.foramtCalcCod(vrTotal);

		let result 		=  Number(vrTotal) - Number(vrTotCob);

		if(result < 0){
			return 0;
		}
		
		return Number(result).toFixed(2);
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
