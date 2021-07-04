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
				<a id="id_produto_destroy" href="{{route('produto.destroy', $registro->id)}}" class="btn btn-sm btn-danger">Deletar</a>
			</div>
		</div>
	</div>
</div>

<script>

</script>