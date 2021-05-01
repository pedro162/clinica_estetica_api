@php $randId = rand(11111, 99999); @endphp
<div class="container">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('marca.update', $registro->id)}}" method="post" class="form row p-5" id="form_marca_atualizar{{$randId}}">
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
</div>

<script>
	$('html body').delegate('form#form_marca_atualizar{{$randId}}','submit', function(ev){

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
					console.log(response.data.id);

					if(response.data.id && (response.data.id > 0)){
						Utilitarios.fecharAssistente('{{$id_assistente}}');
						
						Utilitarios.assistenteMensage('Registro atualizado com sucesso')
						atualizaRelatorio();
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