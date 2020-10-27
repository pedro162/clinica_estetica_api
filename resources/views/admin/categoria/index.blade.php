<div class="row">
	<div class="col-md-6">
		<h4>Lista de Categorias</h4>	
	</div> 
	<div class="col-md-6">
		<div class="form-inline" style="float:right;">
			Buscar:
			<input type="search" name="busca_tabela" class="form-control form-control-sm ml-2">
		</div>
	</div> 
	<div class="col">
		<table style="width: 100%;" class="table table-lg table-responsive table-hover">
			<thead>
				<tr>
					<th>
						Cód
					</th>
					<th>
						Nome Categoria
					</th>
					<th>
						Ativo
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($registro as $valor)
				<tr class="assistenteModalCategoria">
					<td class="text-right">{{$valor->id}}</td>
					<td>{{$valor->name}}</td>
					<td>{{$valor->active == 'yes' ? 'Sim' : 'Não'}}</td>
					<input type="hidden" name="produto" value="{{$valor->id}}">
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>