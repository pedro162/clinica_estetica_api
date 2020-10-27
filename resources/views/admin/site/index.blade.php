@extends('layouts.app')
@section('content')
	<div class="container">
		<h2>Lista de produtos</h2>
		<div class="row">
			<table class="table table-responsive table-hover">
				<thead>
					<tr>
						<th>Nome</th>
						<th>Descrição</th>
						<th>Imagem</th>
						<th>Preço</th>
						<th>Estoque</th>
						<th>Ativo</th>
						<th>Destaque</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
					@foreach($registro as $val)
					<tr>
						<td>{{strtolower($val->name)}}</td>
						<td>{{strtolower($val->description)}}</td>
						<td>{{strtolower($val->price)}}</td>
						<td><img src="{{asset($val->image)}}" style="width: 50px;"></td>
						<td>{{strtolower($val->stock)}}</td>
						<td>{{strtolower($val->active)}}</td>
						<td>{{strtolower($val->spotlight)}}</td>
						<td>
							<a href="#" class="btn btn-sm btn-dark">Visualizar</a>
							<a href="#" class="btn btn-sm btn-primary">Editar</a>
							<a href="#" class="btn btn-sm btn-danger">Excluir</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection