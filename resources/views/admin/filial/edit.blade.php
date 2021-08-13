@php $randId = rand(11111, 99999); @endphp

<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{route('ncm.update', $registro->id)}}" method="post" class="form" id="form_{{$randId}}" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				
				<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
				<hr/>

				<div class="row mt-5" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">NCM</label>
						<input type="text" name="codNcm" class="form-control form-control-sm" value="{{$registro->codNcm}}">
					</div>
					

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Descrição</label>
						<input type="text" name="nmNcm" class="form-control form-control-sm" value="{{$registro->nmNcm}}" >
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