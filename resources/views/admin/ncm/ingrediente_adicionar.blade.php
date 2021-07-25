<div class="container">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('produto.ingrediente.salvar', $produto->id)}}" method="post" class="form row p-5" id="form_produto_adicionar_ingrediente">
				@csrf
				<div class="form-group col-md-12 col-sm-12">
					<label class="label">Ingedientes</label>
					<select type="text" name="marca_id" class="form-control form-control-sm" multiple="multiple">
						@foreach($registros as $registro)
							<option value="{{$registro->id}}">{{$registro->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="col">
					<button type="submit" class=" btn btn-sm btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>	
</div>