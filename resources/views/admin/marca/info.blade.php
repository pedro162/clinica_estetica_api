<div class="row">
	<div class="col">
		<h4 class="alert alert-warning">Deseja realmente deletar este registro?</h4>
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-sm-12">
		<table class="table table-responsive table-hover">
			<tbody>
				<tr>
					<td>Marca:</td>
					<td>{{$registro->name}}</td>
				</tr>
				<tr>
					<td colspan="2">

					</td>
				</tr>
			</tbody>							
		</table>
	</div>
	<div class="col-md-6 col-sm-12">
		<table class="table table-responsive table-hover">
			<thead>
				<tr>
					<td>Codigo</td>
					<td>Produto</td>
				</tr>
			</thead>
			<tbody>
				@foreach($registro->produto as $produto)
				<tr>
					<td>
						{{$produto->id}}
					</td>
					<td>
						{{$produto->name}}
					</td>
				</tr>
				@endforeach
			</tbody>
			<tfooter>
				<tr><td colspan="2">Produtos relacionados</td></tr>
			</tfooter>							
		</table>
	</div>
	<div class="col-md-12 col-sm-12" align="right">
		<a id="id_produto_destroy" onClick="destroy(this);" href="{{route('marca.destroy', $registro->id)}}" class="btn btn-sm btn-danger">Deletar</a>
	</div>
</div>


<script>
	function destroy(element){
		try{

			let url = $(element).attr('href');
			$.ajax({
					url:url,
					type:'GET',
					dataType:'json',
					data:null,
					processData:false,
					contentType:false,
					success:function(response){
						console.log(response);
						Utilitarios.fecharAssistente({{$idAssistente}});
						Utilitarios.assistenteMensage('Registro deletado com sucesso');
						@php echo base64_decode($callBack) @endphp
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
				console.log('Erro: '+ex.message);
		}

	}
</script>