<div class="row">
	<div class="col">
		<h4 class="alert alert-warning">Deseja realmente deletar este registro?</h4>
	</div>
</div>
<div class="row">
	<div class="col-md-8 col-sm-12">
		<table class="table table-sm table-responsive table-hover">
			<tbody>
				<tr>
					<td>{{$registro->tipo == 'fisica' ? 'Nome' : 'Razão Social'}} :</td>
					<td style="width: 100%;">{{$registro->name}}</td>
				</tr>
				<tr>
					<td>{{$registro->tipo == 'fisica' ? 'Sobrenome' : 'Nome Fantasia'}}:</td>
					<td style="width: 100%;">{{$registro->nome_complementar}}</td>
				</tr>
				<tr>
					<td>{{$registro->tipo == 'fisica' ? 'CPF' : 'CNPJ'}}:</td>
					<td style="width: 100%;">{{$registro->documento}}</td>
				</tr>
				<tr>
					<td>{{$registro->tipo == 'fisica' ? 'RG' : 'IE'}} :</td>
					<td style="width: 100%;">{{$registro->documento_complementar}}</td>
				</tr>
				<tr>
					<td>E-mail :</td>
					<td style="width: 100%;">{{$registro->email}}</td>
				</tr>
				@if($registro->sexo != null)
				<tr>
					<td>Sexo:</td>
					<td style="width: 100%;">{{$registro->sexo}}</td>
				</tr>
				@endif
			</tbody>							
		</table>
	</div>
	<div class="col-md-4 col-sm-12">
		<table class="table table-sm table-responsive table-hover">
			<thead>
				<tr>
					<td style="width: 100%;">Contato</td>
				</tr>
			</thead>
			<tbody>
				@foreach($registro->telefone as $fone)
				<tr>
					<td style="width: 100%;">
						{{$fone->numero}}
					</td>
				</tr>
				@endforeach
			</tbody>						
		</table>
	</div>
	<div class="col-md-12 col-sm-12" align="right">
		<a id="id_pessoa_destroy" href="{{route('pessoa.destroy', $registro->id)}}" class="btn btn-sm btn-danger">Deletar</a>
	</div>
</div>

<script type="text/javascript">
	//deleta uma pessoa action
	$('body').delegate('#assistenteModal #id_pessoa_destroy', 'click', function(ev){

		try{

			ev.preventDefault();

			let url = $(this).attr('href');
			
			Utilitarios.assistentAjaxModal('GET',url, 'HTML','Pessoa-Deletar', 'md')

			$.ajax({
				url:url,
				type:'GET',
				dataType:'json',
				success:function(response){
					Utilitarios.assistenteModal(response.message, width, title);
					
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