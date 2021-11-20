<div class="row">
	<div class="col">
		<h4 class="alert alert-warning">Deseja realmente deletar este registro?</h4>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<table class="table table-responsive table-hover">
			<tbody>
				<tr>
					<td>Código:</td>
					<td>{{$registro->id}}</td>
				</tr>
				<tr>
					<td>Caixa:</td>
					<td>{{$registro->name}}</td>
				</tr>
				<tr>
					<td>Saldo:</td>
					<td>{{$registro->vrSaldo}}</td>
				</tr>
				<tr>
					<td>Tipo de saldo:</td>
					<td>{{$registro->tpSaldo}}</td>
				</tr>
				<tr>
					<td>Tipo:</td>
					<td>{{$registro->type}}</td>
				</tr>
				<tr>
					<td>Status de bloqueio:</td>
					<td>{{$registro->status_bloqueio}}</td>
				</tr>

				<tr>
					<td>Status de abertura:</td>
					<td>{{$registro->status_abertura}}</td>
				</tr>

				

			</tbody>							
		</table>
	</div>
	<div class="col-md-12 col-sm-12" align="right">
		<a id="id_produto_destroy" onClick="destroy(this);" href="{{route('caixa.destroy', $registro->id)}}" class="btn btn-sm btn-danger">Deletar</a>
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