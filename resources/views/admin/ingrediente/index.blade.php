<div class="row">
	<div class="col-md-6">
		<h4>Lista de produtos</h4>	
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
						Nome Produto
					</th>
					<th>
						Descrição
					</th>
					<th>
						Marca
					</th>
					<th>
						Categoria
					</th>
					<th>
						Preço
					</th>
					<th>
						Destaque ?
					</th>
					<th>
						Imagem
					</th>
					<th>
						Estoque
					</th><!--
					<th>
						Ação
					</th>-->
				</tr>
			</thead>
			<tbody>
				@foreach($registro as $valor)
				<tr class="assistenteModal">
					<td class="text-right">{{$valor->id}}</td>
					<td>{{$valor->name}}</td>
					<td>{{$valor->description}}</td>
					<td>{{$valor->marca}}</td>
					<td>{{$valor->categoria}}</td>
					<td>{{$valor->price}}</td>
					<td>{{($valor->spotlight == 'yes') ? 'Sim' : 'Não'}}</td>
					<td><img src="{{asset($valor->image)}}"></td>
					<td class="text-right">{{$valor->stock}}</td>
					<!--<td>
						<a href="#" class="btn btn-sm btn-dark mb-sm-1">Visualizar</a>
						<a href="#" class="btn btn-sm btn-primary mb-sm-1">Editar</a>
						<a href="#" class="btn btn-sm btn-danger mb-sm-1">Deletar</a>
					</td>-->
					<input type="hidden" name="produto" value="{{$valor->id}}">
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>