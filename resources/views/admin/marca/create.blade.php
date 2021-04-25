
@php $randId = rand(11111, 99999); @endphp
<div class="container">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('marca.store')}}" method="post" class="form row p-5" id="form_marca_cadastrar{{$randId}}">
				@csrf
				<div class="form-group col-md-12 col-sm-12">
					<label class="label">Nome</label>
					<input type="text" name="name" class="form-control form-control-sm">
				</div>
				<div class="col">
					<button id="btn-salvar{{$randId}}" type="submit" class=" btn btn-sm btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>	
</div>

<script>
	$('html body').delegate('form#form_marca_cadastrar{{$randId}}','submit', function(ev){

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

						if(id == 'form_marca_atualizar'){

							Utilitarios.assistenteMensageAlert('Registro atualizado com sucesso');

						}else{

							Utilitarios.assistenteMensageAlert('Registro cadastrado com sucesso');

						}

					}else{

						if(id == 'form_marca_atualizar'){

							Utilitarios.assistenteMensageAlert('Erro ao atuaolizar registro', 'warning');

						}else{

							Utilitarios.assistenteMensageAlert('Erro ao cadastrar registro', 'warning');

						}

						
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


</script>