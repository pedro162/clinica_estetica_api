
@php $randId = rand(11111, 99999); @endphp

<div class="row p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('caixa.store')}}" method="post" class="form" id="form{{$randId}}">
			@csrf
			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			<hr/>

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
			</div>
			<div class="row ">
				<div class="form-group col-md-6 col-sm-12">	
					@php
						
						$idCategoria 					= 'conta_categoria_id';
						$typeCategoria 					= 'number';
						$nameCategoria 					= 'conta_categoria_id';
						$labelCategoria 				= 'Cód';
						$idDescriptionCategoria 		= 'name';
						$typeDescrptionCategoria 		= 'text';
						$nameDescriptionCategoria 		= 'name';
						$labelDescriptionCategoria 		= 'Categoria';
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
					<label class="label" for="typo">Tipo</label>
					<select name="typo" id="typo" class="form-control form-control-sm">
						<option value="" selected="selected" disabled="">Selecionde</option>
						<option value="receber">Receber</option>
						<option value="pagar">Pagar</option>
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
	const assistente{{$randId}} = '{{$idAssistente}}';
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