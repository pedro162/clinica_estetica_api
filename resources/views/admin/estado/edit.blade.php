@php $randId = rand(11111, 99999); @endphp

<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{route('estado.update', $registro->id)}}" method="post" class="form" id="form_{{$randId}}" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				
				<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
				<hr/>
				<div  class="row" >
					<div class="form-group col-md-12 col-sm-12">
						<label class="label" for="nmEStado{{$randId}}" >Descrição</label>
						<input type="text" value="{{$registro->nmEStado}}" name="nmEStado" id="nmEStado{{$randId}}" class="form-control form-control-sm ">
					</div>
				</div>

				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="pais_id{{$randId}}">País</label>
						<select type="text"  name="pais_id" title="Define o país do estado" id="pais_id{{$randId}}" class="form-control form-control-sm">
							@foreach($paises as $pais)
								<option {{isset($registro->pais_id) && $registro->pais_id == $pais->id ? 'selected' : ''}} value="{{$pais->id}}">{{$pais->nmPais}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="padrao{{$randId}}" >Definir como padrão</label>
						<select type="text" name="padrao" title="Define o estado como padrão" id="padrao{{$randId}}" class="form-control form-control-sm">
							<option {{isset($registro->padrao) && trim($registro->padrao) == 'yes' ? 'selected' : ''}} value="yes">Sim</option>
							<option {{isset($registro->padrao) && trim($registro->padrao) == 'no' ? 'selected' : ''}} value="no" >Não</option>
						</select>
					</div>
				</div>	

				<div  class="row" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="codEstado{{$randId}}" >Código do estado</label>
						<input type="text" value="{{$registro->codEstado}}" name="codEstado" title="Classe de enquadramento" id="codEstado{{$randId}}" class="form-control form-control-sm ">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label" for="sigla{{$randId}}" >Sigla</label>
						<input type="text" value="{{$registro->sigla}}"  name="sigla" title="Classe de enquadramento" id="sigla{{$randId}}" class="form-control form-control-sm ">
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
</div>
<script>
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
</script>