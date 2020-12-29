@php $randId = rand(11111, 99999); @endphp
<div class="row">
	<div class="col">
		<h4 class="alert alert-warning">Deseja realmente deletar este registro?</h4>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<table class="table table-sm table-responsive table-hover">
			<tbody>
				<tr>
					<td>Titular:</td>
					<td style="width: 100%;">{{$pessoa->name.' '.$pessoa->name_complementar}}</td>
				</tr>
				<tr>
					<td>Cep:</td>
					<td style="width: 100%;">{{$registro->cep}}</td>
				</tr>
				<tr>
					<td>Logradouro:</td>
					<td style="width: 100%;">{{$registro->logradouro}}</td>
				</tr>
				<tr>
					<td>Complemento:</td>
					<td style="width: 100%;">{{$registro->complemento}}</td>
				</tr>
				<tr>
					<td>Número:</td>
					<td style="width: 100%;">{{$registro->numero}}</td>
				</tr>
				<tr>
					<td>Cidade:</td>
					<td style="width: 100%;">{{$registro->cidade}}</td>
				</tr>
				<tr>
					<td>Estado:</td>
					<td style="width: 100%;">{{$registro->estado}}</td>
				</tr>
			</tbody>							
		</table>
	</div>
	<div class="col-md-12 col-sm-12" align="right">
		<a id="id_logradouro_destroy{{$randId}}" href="{{route('logradouro.destroy', [$registro->id, $pessoa->id])}}" class="btn btn-sm btn-danger">Deletar</a>
	</div>
</div>

<script type="text/javascript">
	//deleta uma pessoa action
	$('body').delegate('#id_logradouro_destroy{{$randId}}', 'click', function(ev){

		try{

			ev.preventDefault();

			let url = $(this).attr('href');
			
			//Utilitarios.assistentAjaxModal('GET',url, 'HTML','Logradouro-Deletar', 'md')

			$.ajax({
				url:url,
				type:'GET',
				dataType:'json',
				success:function(response){
					Utilitarios.assistenteModal('<div class="col h4 alert alert-primary">'+response.mensagem+'</div>', 'md', 'Logradouro-Deletar');
					
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

			});

		}catch(ex){
			console.log('Erro: '+ex.message);
		}
		

	});
</script>