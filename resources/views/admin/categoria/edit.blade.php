<div class="container">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('categoria.update', $registro->id)}}" method="post" class="form row p-5">
				@csrf
				@method('PUT')
				<div class="form-group col-md-12 col-sm-12">
					<label class="label">Nome</label>
					<input type="text" name="name" class="form-control form-control-sm" value="{{$registro->name}}">
				</div>
				<div class="col">
					<button type="submit" class=" btn btn-sm btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>	
</div>