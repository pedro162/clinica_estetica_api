<div class="container">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('categoria.store')}}" method="post" class="form row p-5">
				@csrf
				<div class="form-group col-md-12 col-sm-12">
					<label class="label">Nome</label>
					<input type="text" name="name" class="form-control form-control-sm">
				</div>
				<div class="col">
					<button type="submit" class=" btn btn-sm btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>	
</div>