@php $randId = rand(11111, 99999); @endphp

<div class="row p-3">
	<div class="col-md-12 col-sm-12">

		<form action="{{route('cidade.update', $registro->id)}}" method="post" class="form" id="form{{$randId}}" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			
			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			<hr/>
			<div  class="row" >
				<div class="form-group col-md-12 col-sm-12">
					<label class="label" for="nmCidade{{$randId}}" >Descrição</label>
					<input type="text" value="{{$registro->nmCidade}}" name="nmCidade" id="nmCidade{{$randId}}" class="form-control form-control-sm ">
				</div>
				
			</div>

			<div  class="row" >


				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="cdCidade{{$randId}}" >Código</label>
					<input type="text" value="{{$registro->cdCidade}}"  name="cdCidade" id="cdCidade{{$randId}}" class="form-control form-control-sm ">
				</div>
				<div class="form-group col-md-6 col-sm-12">	
					@php
						
						$idEstado 					= 'estado_id';
						$typeEstado 				= 'number';
						$nameEstado 				= 'estado_id';
						$labelEstado 				= 'Cód';
						$idDescriptionEstado 		= 'nmEStado';
						$typeDescrptionEstado 		= 'text';
						$nameDescriptionEstado 		= 'nmEStado';
						$labelDescriptionEstado 	= 'Descrição';
						$valueDescriptionEstado 	= $registro->estado->nmEStado;
						$valueEstado 				= $registro->estado->id;
						$colEstado 					= "3";
						$colDescriptionEstado 		= "8";
						$searshEstado 				= "searshEstado".$randId."();";

						//dd($valueDescriptionEstado);
					@endphp
					<x-controll-filter
						:idCod="$idEstado"
						:typeCod="$typeEstado"
						:nameCod="$nameEstado"
						:labelCod="$labelEstado"
						:idDescription="$idDescriptionEstado"
						:typeDescrption="$typeDescrptionEstado"
						:nameDescription="$nameDescriptionEstado"
						:labelDescription="$labelDescriptionEstado"
						:valueDescription="$valueDescriptionEstado"
						:valueCod="$valueEstado"
						:colCod="$colEstado"
						:colDescription="$colDescriptionEstado"
						:searsh="$searshEstado"
					/>
				</div>

				
			</div>
			
			
			<div class="row">

				<div class="col-md-8 col-sm-12">
				</div>
				<div class="col-md-4 col-sm-12" style="text-align: right;">
					<button type="submit" class=" btn btn-md btn-primary">Salvar</button>
				</div>
			</div>
		</form>
	</div>	
</div>
<script>
	const assistente = '{{$idAssistente}}';
	$("#tabs{{$randId}}").tabs()
	//edita ou salva um produto
	$('html body').find('#form{{$randId}}').on('submit', function(ev){
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

	function searshEstado{{$randId}}(){

		try{
			
			let url = '/estado/head';
			let data =  preparaBasicRequestPost{{$randId}}();
			

			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')
			Utilitarios.assistentAjaxModal('POST',url, 'HTML','ESTADOS', 'sm', '700px', null, data)

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