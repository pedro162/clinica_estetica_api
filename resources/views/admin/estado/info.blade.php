<div class="row">
	<div class="col">
		<h4 class="alert alert-warning">Deseja realmente deletar este registro?</h4>
	</div>
</div>
<div class="row" >
	<div class="col-md-12 col-sm-12 "  >
		<div class="row"  >
			<div class="col-md-12 col-sm-12">
				<table class="table table-responsive table-hover" style="width: 100%;">
					<tbody>
						<tr>
							<td>NCM:</td>
							<td>{{$registro->codNcm ? $registro->codNcm : ''}}</td>
						</tr>
						<tr>
							<td>Código NCM:</td>
							<td>{{$registro->codNcm ? $registro->codNcm : ''}}</td>
						</tr>
						<tr>
							<td>Alíquota nacional:</td>
							<td>{{$registro->vrAliqNacional ? number_format($registro->vrAliqNacional, 2, ',', '.') : ''}}</td>
						</tr>
						<tr>
						<td>Alíquota importada:</td>
							<td>{{$registro->vrAliqImportada ? number_format($registro->vrAliqImportada, 2, ',', '.') : ''}}</td>
						</tr>
						<tr>
						<td>Alíquota estadual:</td>
						<td>{{$registro->vrAliqEstadual ? number_format($registro->vrAliqEstadual, 2, ',', '.') : ''}}</td>
						</tr>
						<tr>
						<td>Alíquota municipal:</td>
							<td>{{$registro->vrAliqMunicipal ? number_format($registro->vrAliqMunicipal, 2, ',', '.') : ''}}</td>
						</tr>
					</tbody>							
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-sm-12" align="right">
				<a id="id_produto_destroy" onClick="destroy(this);" href="{{route('ncm.destroy', $registro->id)}}" class="btn btn-sm btn-danger">Deletar</a>
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