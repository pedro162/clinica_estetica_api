@php $randId = rand(11111, 99999);
	
 @endphp
 <div class="row p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('marca.update', $registro->id)}}" method="post" class="form" id="form_{{$randId}}">
			@csrf
			@method('PUT')
			<div class="form-group col-md-12 col-sm-12">
				<label class="label">Nome</label>
				<input type="text" name="name" class="form-control form-control-sm" value="{{$registro->name}}">
			</div>
			<div class="col">
				<button type="submit" class=" btn btn-sm btn-primary">Salvar</button>
			</div>
		</form>
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