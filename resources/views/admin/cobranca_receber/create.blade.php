@php $randId = rand(11111, 99999);@endphp

<div class="row p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('receber.store')}}" method="post" class="form " id="form{{$randId}}" enctype="multipart/form-data">
			@csrf
			
			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			<hr/>
		
			<div  class="row" >
				<div class="form-group col-md-6 col-sm-12">	
					@php
						
						$idPessoa 					= 'pessoa_id';
						$typePessoa 				= 'number';
						$namePessoa 				= 'pessoa_id';
						$labelPessoa 				= 'Cód';
						$idDescriptionPessoa 		= 'name';
						$typeDescrptionPessoa 		= 'text';
						$nameDescriptionPessoa 		= 'name';
						$labelDescriptionPessoa 	= 'Pessoa';
						$valueDescriptionPessoa 	= "";
						$valuePessoa 				= "";
						$colPessoa 					= "3";
						$colDescriptionPessoa 		= "8";
						$searshPessoa 				= "searshPessoa".$randId."();";
					@endphp
					<x-controll-filter
						:idCod="$idPessoa"
						:typeCod="$typePessoa"
						:nameCod="$namePessoa"
						:labelCod="$labelPessoa"
						:idDescription="$idDescriptionPessoa"
						:typeDescrption="$typeDescrptionPessoa"
						:nameDescription="$nameDescriptionPessoa"
						:labelDescription="$labelDescriptionPessoa"
						:valueDescription="$valueDescriptionPessoa"
						:valueCod="$valuePessoa"
						:colCod="$colPessoa"
						:colDescription="$colDescriptionPessoa"
						:searsh="$searshPessoa"
					/>
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="descricao{{$randId}}" >Descrição</label>
					<input type="text" name="descricao" id="descricao{{$randId}}" class="form-control form-control-sm ">
				</div>
				
			</div>
			<div  class="row" >


				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="vrBruto{{$randId}}" >Valor</label>
					<input type="text" name="vrBruto" id="vrBruto{{$randId}}" class="form-control form-control-sm ">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="vrDesconto{{$randId}}" >Desconto</label>
					<input type="text" name="vrDesconto" id="vrDesconto{{$randId}}" class="form-control form-control-sm ">
				</div>

			</div>
			<div  class="row" >


				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="vrJuros{{$randId}}" >Acréscimos</label>
					<input type="text" name="vrJuros" id="vrJuros{{$randId}}" class="form-control form-control-sm ">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="isPersonalisado{{$randId}}" >Personalizado</label>
					<select name="isPersonalisado" id="isPersonalisado{{$randId}}" class="form-control form-control-sm">
						<option value="yes">Sim</option>
						<option value="no" selected="selected" >Não</option>
					</select>
				</div>
			</div>
			<div  class="row" >

				<div class="form-group col-md-6 col-sm-12">	
					@php
						//ex: Receita, Vendas
						$idCategoria 					= 'categoria_id';
						$typeCategoria 					= 'number';
						$nameCategoria 					= 'categoria_id';
						$labelCategoria 				= 'Cód';
						$idDescriptionCategoria 		= 'nmCategoria';
						$typeDescrptionCategoria 		= 'text';
						$nameDescriptionCategoria 		= 'nmCategoria';
						$labelDescriptionCategoria 		= 'Cateoria de conta';
						$valueDescriptionCategoria 		= "";
						$valueCategoria 				= "";
						$colCategoria 					= "3";
						$colDescriptionCategoria 		= "8";
						$searshCategoria 				= "searshCategoria".$randId."();";
					@endphp
					<x-controll-filter
						:idCod="$idCategoria"
						:typeCod="$typeCategoria"
						:nameCod="$nameCategoria"
						:labelCod="$labelCategoria"
						:idDescription="$idDescriptionCategoria"
						:typeDescrption="$typeDescrptionCategoria"
						:nameDescription="$nameDescriptionCategoria"
						:labelDescription="$labelDescriptionCategoria"
						:valueDescription="$valueDescriptionCategoria"
						:valueCod="$valueCategoria"
						:colCod="$colCategoria"
						:colDescription="$colDescriptionCategoria"
						:searsh="$searshCategoria"
					/>
				</div>


				
				<div class="form-group col-md-6 col-sm-12">	
					@php
						
						//ex: Banco brasil, Caixa principal

						$idConta 					= 'conta_id';
						$typeConta 					= 'number';
						$nameConta 					= 'conta_id';
						$labelConta 				= 'Cód';
						$idDescriptionConta 		= 'conta_name';
						$typeDescrptionConta 		= 'text';
						$nameDescriptionConta 		= 'conta_name';
						$labelDescriptionConta 		= 'Conta';
						$valueDescriptionConta 		= "";
						$valueConta 				= "";
						$colConta 					= "3";
						$colDescriptionConta 		= "8";
						$searshConta 				= "searshConta".$randId."();";
					@endphp
					<x-controll-filter
						:idCod="$idConta"
						:typeCod="$typeConta"
						:nameCod="$nameConta"
						:labelCod="$labelConta"
						:idDescription="$idDescriptionConta"
						:typeDescrption="$typeDescrptionConta"
						:nameDescription="$nameDescriptionConta"
						:labelDescription="$labelDescriptionConta"
						:valueDescription="$valueDescriptionConta"
						:valueCod="$valueConta"
						:colCod="$colConta"
						:colDescription="$colDescriptionConta"
						:searsh="$searshConta"
					/>
				</div>
								
			</div>	
			
			<div  class="row" id="intervalo-pagamento{{$randId}}" >

				<div class="form-group col-md-6 col-sm-12">	
					@php
						//ex: 30, 15 dias
						$idIntervaloPagamento 					= 'IntervaloPagamento_id';
						$typeIntervaloPagamento 				= 'number';
						$nameIntervaloPagamento 				= 'IntervaloPagamento_id';
						$labelIntervaloPagamento 				= 'Cód';
						$idDescriptionIntervaloPagamento 		= 'name_IntervaloPagamento';
						$typeDescrptionIntervaloPagamento 		= 'text';
						$nameDescriptionIntervaloPagamento 		= 'name_IntervaloPagamento';
						$labelDescriptionIntervaloPagamento 	= 'IntervaloPagamento';
						$valueDescriptionIntervaloPagamento 	= "";
						$valueIntervaloPagamento 				= "";
						$colIntervaloPagamento 					= "3";
						$colDescriptionIntervaloPagamento 		= "8";
						$searshIntervaloPagamento 				= "searshIntervaloPagamento".$randId."();";
					@endphp
					<x-controll-filter
						:idCod="$idIntervaloPagamento"
						:typeCod="$typeIntervaloPagamento"
						:nameCod="$nameIntervaloPagamento"
						:labelCod="$labelIntervaloPagamento"
						:idDescription="$idDescriptionIntervaloPagamento"
						:typeDescrption="$typeDescrptionIntervaloPagamento"
						:nameDescription="$nameDescriptionIntervaloPagamento"
						:labelDescription="$labelDescriptionIntervaloPagamento"
						:valueDescription="$valueDescriptionIntervaloPagamento"
						:valueCod="$valueIntervaloPagamento"
						:colCod="$colIntervaloPagamento"
						:colDescription="$colDescriptionIntervaloPagamento"
						:searsh="$searshIntervaloPagamento"
					/>
				</div>

				<div class="form-group col-md-6 col-sm-12">	
					@php
						//ex: 12x, 24x
						$idPlanoPagamento 					= 'plano_pagamento_id';
						$typePlanoPagamento 				= 'number';
						$namePlanoPagamento 				= 'plano_pagamento_id';
						$labelPlanoPagamento 				= 'Cód';
						$idDescriptionPlanoPagamento 		= 'plano_pagamento_name';
						$typeDescrptionPlanoPagamento 		= 'text';
						$nameDescriptionPlanoPagamento 		= 'plano_pagamento_name';
						$labelDescriptionPlanoPagamento 	= 'Nº parcelas';
						$valueDescriptionPlanoPagamento 	= "";
						$valuePlanoPagamento 				= "";
						$colPlanoPagamento 					= "3";
						$colDescriptionPlanoPagamento 		= "8";
						$searshPlanoPagamento 				= "searshPlanoPagamento".$randId."();";
					@endphp
					<x-controll-filter
						:idCod="$idPlanoPagamento"
						:typeCod="$typePlanoPagamento"
						:nameCod="$namePlanoPagamento"
						:labelCod="$labelPlanoPagamento"
						:idDescription="$idDescriptionPlanoPagamento"
						:typeDescrption="$typeDescrptionPlanoPagamento"
						:nameDescription="$nameDescriptionPlanoPagamento"
						:labelDescription="$labelDescriptionPlanoPagamento"
						:valueDescription="$valueDescriptionPlanoPagamento"
						:valueCod="$valuePlanoPagamento"
						:colCod="$colPlanoPagamento"
						:colDescription="$colDescriptionPlanoPagamento"
						:searsh="$searshPlanoPagamento"
					/>
				</div>
				
			</div>	
			<div  class="row" >


				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="intervaloPgtoPersonalizado{{$randId}}" >Intervalo personalizado</label>
					<input type="number" readonly="readonly" min="1" name="intervaloPgtoPersonalizado" id="intervaloPgtoPersonalizado{{$randId}}" class="form-control form-control-sm ">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="nrParcelasPersonalizado{{$randId}}" >Nº parcelas personalizados</label>
					<input type="number" readonly="readonly" min="1" name="nrParcelasPersonalizado" id="nrParcelasPersonalizado{{$randId}}" class="form-control form-control-sm ">
				</div>
			</div>
			
			<div  class="row" >
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="dtPrimeiraParcela{{$randId}}" >DT. primeira parcela</label>
					<input type="text" name="dtPrimeiraParcela" id="dtPrimeiraParcela{{$randId}}" class="form-control form-control-sm ">
				</div>
				<div class="form-group col-md-6 col-sm-12">	
					@php
						//ex: Boleto, Cartao
						$idFomaRecebimento 					= 'forma_pagamento_id';
						$typeFomaRecebimento 				= 'number';
						$nameFomaRecebimento 				= 'forma_pagamento_id';
						$labelFomaRecebimento 				= 'Cód';
						$idDescriptionFomaRecebimento 		= 'forma_pagamento_name';
						$typeDescrptionFomaRecebimento 		= 'text';
						$nameDescriptionFomaRecebimento 	= 'forma_pagamento_name';
						$labelDescriptionFomaRecebimento 	= 'Forma de recebimento';
						$valueDescriptionFomaRecebimento 	= "";
						$valueFomaRecebimento 				= "";
						$colFomaRecebimento 				= "3";
						$colDescriptionFomaRecebimento 		= "8";
						$searshFomaRecebimento 				= "searshFomaRecebimento".$randId."();";
					@endphp
					<x-controll-filter
						:idCod="$idFomaRecebimento"
						:typeCod="$typeFomaRecebimento"
						:nameCod="$nameFomaRecebimento"
						:labelCod="$labelFomaRecebimento"
						:idDescription="$idDescriptionFomaRecebimento"
						:typeDescrption="$typeDescrptionFomaRecebimento"
						:nameDescription="$nameDescriptionFomaRecebimento"
						:labelDescription="$labelDescriptionFomaRecebimento"
						:valueDescription="$valueDescriptionFomaRecebimento"
						:valueCod="$valueFomaRecebimento"
						:colCod="$colFomaRecebimento"
						:colDescription="$colDescriptionFomaRecebimento"
						:searsh="$searshFomaRecebimento"
					/>
				</div>
			</div>
			<div  class="row" >


				<div class="form-group col-md-6 col-sm-12">	
					@php
						
						$idCaixa 					= 'caixa_id';
						$typeCaixa 					= 'number';
						$nameCaixa 					= 'caixa_id';
						$labelCaixa 				= 'Cód';
						$idDescriptionCaixa 		= 'name_caixa';
						$typeDescrptionCaixa 		= 'text';
						$nameDescriptionCaixa 		= 'name_caixa';
						$labelDescriptionCaixa 		= 'Caixa';
						$valueDescriptionCaixa 		= "";
						$valueCaixa 				= "";
						$colCaixa 					= "3";
						$colDescriptionCaixa 		= "8";
						$searshCaixa 				= "searshCaixa".$randId."();";
					@endphp
					<x-controll-filter
						:idCod="$idCaixa"
						:typeCod="$typeCaixa"
						:nameCod="$nameCaixa"
						:labelCod="$labelCaixa"
						:idDescription="$idDescriptionCaixa"
						:typeDescrption="$typeDescrptionCaixa"
						:nameDescription="$nameDescriptionCaixa"
						:labelDescription="$labelDescriptionCaixa"
						:valueDescription="$valueDescriptionCaixa"
						:valueCod="$valueCaixa"
						:colCod="$colCaixa"
						:colDescription="$colDescriptionCaixa"
						:searsh="$searshCaixa"
					/>
				</div>
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="documento{{$randId}}" >Documento</label>
					<input type="text" name="documento" id="documento{{$randId}}" class="form-control form-control-sm ">
				</div>
				
			</div>	

			<div class="row">
				<div class="col-md-8 col-sm-12">
				</div>
				<div class="col-md-4 col-sm-12" style="text-align: right;">
					<button type="submit" class=" btn btn-md btn-primary"><b>Salvar</b></button>
				</div>
			</div>
		</form>
	</div>
</div>	

<script>

	$( "#dtPrimeiraParcela{{$randId}}" ).datepicker({
      changeMonth: true,
      changeYear: true,
    })

    $('#isPersonalisado{{$randId}}').on('change',function(){

    	let val = $(this).val();
    	
    	if(val == 'yes'){
    		$('#intervaloPgtoPersonalizado{{$randId}}').removeAttr('readonly')
    		$('#nrParcelasPersonalizado{{$randId}}').removeAttr('readonly')

    		$('html').find('#intervalo-pagamento{{$randId}}').find('#plano_pagamento_id').attr('readonly', 'readonly')
    		$('html').find('#intervalo-pagamento{{$randId}}').find('#plano_pagamento_name').attr('readonly', 'readonly')

    		$('html').find('#intervalo-pagamento{{$randId}}').find('#name_IntervaloPagamento').attr('readonly', 'readonly')
    		$('html').find('#intervalo-pagamento{{$randId}}').find('#IntervaloPagamento_id').attr('readonly', 'readonly')

    	}else{
    		$('#intervaloPgtoPersonalizado{{$randId}}').attr('readonly', 'readonly')
    		$('#nrParcelasPersonalizado{{$randId}}').attr('readonly', 'readonly')

    		$('html').find('#intervalo-pagamento{{$randId}}').find('#plano_pagamento_id').removeAttr('readonly')
    		$('html').find('#intervalo-pagamento{{$randId}}').find('#plano_pagamento_name').removeAttr('readonly')

    		$('html').find('#intervalo-pagamento{{$randId}}').find('#name_IntervaloPagamento').removeAttr('readonly')
    		$('html').find('#intervalo-pagamento{{$randId}}').find('#IntervaloPagamento_id').removeAttr('readonly')


    		

    	}
    	
    	
		
    })

	const assistente{{$randId}} = '{{$idAssistente}}';
	let callBack{{$randId}} = '{{$callBack}}'
	//edita ou salva um produto
	$('html body').find('#form{{$randId}}').on('submit', function(ev){

		try{

			let url = $(this).attr('action');
			let id = $(this).attr('id');

			let form = new FormData($(this)[0]);
			$.ajax({
				url:url,
				type:'POST',
				dataType:'json',
				data:form,
				processData:false,
				contentType:false,
				success:function(response){
					console.log(response);
					console.log(response.mensagem.id);

					if(response.mensagem.hasOwnProperty('id') || response.mensagem == true){
						Utilitarios.fecharAssistente(assistente{{$randId}});
						Utilitarios.assistenteMensage('Registrado com sucesso');
						@php echo base64_decode($callBack) @endphp

					}else{

						Utilitarios.assistenteMensage('Erro ao atuaolizar registro', 'warning', 'Erro');


					}
				},
				error:function(response, status, error){
					//console.log(response, status, error)
					console.log(response.responseJSON);
					let objErros = response.responseJSON.errors
					let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';
					for (let prop in objErros){
						msg+='<strong>'+prop+': </strong>'+objErros[prop]+'<br/>';
					}

					Utilitarios.assistenteMensageAlert(msg, 'warning');
				}


			})

		}catch(ex){

			console.log(ex.message);
		}

		ev.preventDefault();
	});

	function searshFomaRecebimento{{$randId}}(){

		try{
			
			let url = '/forma_pagamento/head';
			let data =  preparaBasicRequestPost{{$randId}}();
			

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','FORMA DE RECEBIMENTO', 'lg', '700px', null, data)

		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function searshPessoa{{$randId}}(){

		try{
			
			let url = '/pessoa/head';
			let data =  preparaBasicRequestPost{{$randId}}();
			

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','PESSOAS', 'lg', '700px', null, data)

		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}


	function searshCategoria{{$randId}}(){

		try{
			
			let url = '/categoria_financeiro/head';
			let data =  preparaBasicRequestPost{{$randId}}();
			

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','FORMA DE RECEBIMENTO', 'lg', '700px', null, data)

		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function searshCaixa{{$randId}}(){

		try{
			
			let url = '/caixa/head';
			let data =  preparaBasicRequestPost{{$randId}}();
			data.append('pesquisar',1)
			data.append('calback_selected',btoa('acaoCaixaSelecionando'));
			data.append('url_pesquisa','/caixa/json');
			

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','CAIXAS', 'lg', '700px', null, data)

		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function searshConta{{$randId}}(){

		try{
			
			let url = '/conta/head';
			let data =  preparaBasicRequestPost{{$randId}}();
			

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','PESSOAS', 'lg', '700px', null, data)

		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function searshIntervaloPagamento{{$randId}}(){

		try{
			
			let url = '/caixa/head';
			let data =  preparaBasicRequestPost{{$randId}}();
			

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','CAIXAS', 'lg', '700px', null, data)

		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}

	function searshPlanoPagamento{{$randId}}(){

		try{
			
			let url = '/conta/head';
			let data =  preparaBasicRequestPost{{$randId}}();
			

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','PESSOAS', 'lg', '700px', null, data)

		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}


	function preparaBasicRequestPost{{$randId}}(){
		let token = $('html').find('#form{{$randId}}').find('input[name="_token"]').val()

		let data = new FormData();
		data.append('idAssistente', '')
		data.append('callBack', ''+callBack{{$randId}}+'')
		data.append('_token', token)

		return data;

	}

	function acaoCaixaSelecionando(dados){
		console.log('-------------- dados aqui -----------------')
		console.log(dados)
	}
</script>