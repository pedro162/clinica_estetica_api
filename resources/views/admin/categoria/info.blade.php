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
					<td>Categoria:</td>
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
		<a id="id_produto_destroy" href="{{route('marca.destroy', $registro->id)}}" class="btn btn-sm btn-danger">Deletar</a>
	</div>
</div>