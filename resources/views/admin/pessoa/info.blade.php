<div class="row">
	<div class="col">
		<h4 class="alert alert-warning">Deseja realmente deletar este registro?</h4>
	</div>
</div>
<div class="row">
	<div class="col-md-8 col-sm-12">
		<table class="table table-responsive table-hover">
			<tbody>
				<tr>
					<td>{{$registro->tipo == 'fisica' ? 'Nome' : 'Razão Social'}} :</td>
					<td>{{$registro->name}}</td>
				</tr>
				<tr>
					<td>{{$registro->tipo == 'fisica' ? 'Sobrenome' : 'Nome Fantasia'}} :</td>
					<td>{{$registro->nome_complementar}}</td>
				</tr>
				<tr>
					<td>{{$registro->tipo == 'fisica' ? 'CPF' : 'CNPJ'}}:</td>
					<td>{{$registro->documento}}</td>
				</tr>
				<tr>
					<td>{{$registro->tipo == 'fisica' ? 'RG' : 'IE'}} :</td>
					<td>{{$registro->documento_complementar}}</td>
				</tr>
				<tr>
					<td>E-mail :</td>
					<td>{{$registro->email}}</td>
				</tr>
				@if($registro->sexo != null)
				<tr>
					<td>Sexo:</td>
					<td>{{$registro->sexo}}</td>
				</tr>
				@endif
			</tbody>							
		</table>
	</div>
	<div class="col-md-4 col-sm-12">
		<table class="table table-responsive table-hover">
			<thead>
				<tr>
					<td>Contato</td>
				</tr>
			</thead>
			<tbody>
				@foreach($registro->telefone as $fone)
				<tr>
					<td>
						{{$fone->numero}}
					</td>
				</tr>
				@endforeach
			</tbody>						
		</table>
	</div>
	<div class="col-md-12 col-sm-12" align="right">
		<a id="id_produto_destroy" href="{{route('pessoa.destroy', $registro->id)}}" class="btn btn-sm btn-danger">Deletar</a>
	</div>
</div>