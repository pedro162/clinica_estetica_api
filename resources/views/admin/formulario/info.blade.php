<div class="row">
	<div class="col">
		<h4 class="alert alert-warning">Deseja realmente deletar este registro?</h4>
	</div>
</div>
<div class="row" >
	<div class="col-md-12 col-sm-12 "  >
		<div class="row"  >
			<div class="col-md-8 col-sm-12">
				<table class="table table-responsive table-hover" style="width: 100%;">
					<tbody>
						<tr>
							<td>Produto:</td>
							<td>{{$registro->name ? $registro->name : ''}}</td>
						</tr>
						<tr>
							<td>Estoque:</td>
							<td>{{$registro->stock ? $registro->stock : ''}}</td>
						</tr>
						<tr>
							<td>Preço:</td>
							<td>{{$registro->price ? $registro->price : ''}}</td>
						</tr>
						<tr>
							<td>Quantidade vendida:</td>
							<td>{{$registro->sold_amout ? $registro->sold_amout : ''}}</td>
						</tr>
						<tr>
							<td>Destaque:</td>
							<td>{{$registro->spotlight == 'yes' ? 'Sim' : 'Não'}}</td>
						</tr>
						<tr>
							<td>Marca:</td>
							<td>{{$registro->marca->name ? $registro->marca->name : ''}}</td>
						</tr>
					</tbody>							
				</table>
			</div>
			<div class="col-md-4 col-sm-12">
				<img src="{{asset($registro->image)}}" style="width: 100%; height: 300px;">
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-sm-12" align="right">
				<a id="id_produto_destroy" onClick="destroy(this);" href="{{route('produto.destroy', $registro->id)}}" class="btn btn-sm btn-danger">Deletar</a>
			</div>
		</div>
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