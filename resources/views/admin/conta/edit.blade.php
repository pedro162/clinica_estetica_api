@php $randId = rand(11111, 99999);
	
 @endphp
 <div class="row p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('caixa.update', $registro->id)}}" method="post" class="form" id="form_{{$randId}}">
			@csrf
			@method('PUT')
			<div class="row  mt-5">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="name">Nome</label>
					<input type="text" value="{{$registro->name}}" name="name" id="name" class="form-control form-control-sm">
				</div>
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="type">Tipo</label>
					<select name="type" id="type" class="form-control form-control-sm">
						<option value="" selected="selected" disabled="">Selecionde</option>
						<option {{isset($registro->type) &&  trim($registro->type) == 'convencional'? 'selected': ''}} value="convencional">Convencional</option>
						<option {{isset($registro->type) &&  trim($registro->type) == 'banco'? 'selected': ''}} value="banco">Banco</option>
					</select>
				</div>
			</div>
			<div class="row ">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="vrMin">Valor mínimo</label>
					<input type="text" value="{{$registro->vrMin}}" name="vrMin" id="vrMin" class="form-control form-control-sm">
				</div>
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="vrMax">Valor máximo</label>
					<input type="text" value="{{$registro->vrMax}}" name="vrMax" id="vrMax" class="form-control form-control-sm">
				</div>
			</div>
			<div class="row ">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="status_bloqueio">Bloquear</label>
					<select name="status_bloqueio" id="status_bloqueio" class="form-control form-control-sm">
						<option value="" selected="selected" disabled="">Selecionde</option>
						<option {{isset($registro->status_bloqueio) &&  trim($registro->status_bloqueio) == 'bloqueado'? 'selected': ''}} value="bloqueado">Sim</option>
						<option {{isset($registro->status_bloqueio) &&  trim($registro->status_bloqueio) == 'liberado'? 'selected': ''}} value="liberado">Não</option>
					</select>
				</div>
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="aceita_transferencia">Aceita tranferência</label>
					<select name="aceita_transferencia" id="aceita_transferencia" class="form-control form-control-sm">
						<option value="" selected="selected" disabled="">Selecionde</option>
						<option {{isset($registro->aceita_transferencia) &&  trim($registro->aceita_transferencia) == 'yes'? 'selected': ''}} value="yes">Sim</option>
						<option {{isset($registro->aceita_transferencia) &&  trim($registro->aceita_transferencia) == 'no'? 'selected': '' }} value="no">Não</option>
					</select>
				</div>
			</div>



			<div class="row  mt-5">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="name">Nome</label>
					<input type="text" name="name" id="name" class="form-control form-control-sm">
				</div>
				<div class="form-group col-md-6 col-sm-12">	
					@php
						
						$idPessoa 					= 'pessoa_id';
						$typePessoa 				= 'number';
						$namePessoa 				= 'pessoa_id';
						$labelPessoa 				= 'Cód';
						$idDescriptionPessoa 		= 'name';
						$typeDescrptionPessoa 		= 'text';
						$nameDescriptionPessoa 		= 'name';
						$labelDescriptionPessoa 	= 'Operador financeiro';
						$valueDescriptionPessoa 	= $registro->pessoa->name;
						$valuePessoa 				= $registro->pessoa->id;
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
			</div>
			<div class="row ">
				<div class="form-group col-md-6 col-sm-12">	
					@php
						
						$idCategoria 					= 'conta_categorias_id';
						$typeCategoria 					= 'number';
						$nameCategoria 					= 'conta_categorias_id';
						$labelCategoria 				= 'Cód';
						$idDescriptionCategoria 		= 'name';
						$typeDescrptionCategoria 		= 'text';
						$nameDescriptionCategoria 		= 'name';
						$labelDescriptionCategoria 		= 'Categoria';
						$valueDescriptionCategoria 		= $registro->categoria->name;
						$valueCategoria 				= $registro->categoria->id;
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
					<label class="label" for="typo">Tipo</label>
					<select name="typo" id="typo" class="form-control form-control-sm">
						<option value="" disabled="">Selecionde</option>
						<option  {{isset($registro->typo) &&  trim($registro->typo) == 'receber'? 'selected': '' }} value="receber">Receber</option>
						<option  {{isset($registro->typo) &&  trim($registro->typo) == 'pagar'? 'selected': '' }} value="pagar">Pagar</option>
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8 col-sm-12">
				</div>
				<div class="col-md-4 col-sm-12" style="text-align: right;">
					<button id="btn-salvar{{$randId}}" type="submit" class=" btn btn-sm btn-primary">Salvar</button>
				</div>
			</div>
		</form>
	</div>	
</div>

<script>

	//const assistente{{$randId}} = '{{$idAssistente}}';
	let callBack{{$randId}} = '{{$callBack}}'
	const assistente = '{{$idAssistente}}';
	$("#tabs{{$randId}}").tabs()
	//edita ou salva um produto
	$('html body').find('#form_{{$randId}}').on('submit', function(ev){
		ev.preventDefault();
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
						Utilitarios.fecharAssistente(assistente);
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

					Utilitarios.assistenteMensage(msg, 'warning', 'Erro');
				}


			})

		}catch(ex){

			console.log(ex.message);
		}

		
	});

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
			
			let url = '/pessoa/head';
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
</script>