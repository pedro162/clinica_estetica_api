<div class="container">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('produto.store')}}" method="post" class="form row p-5">
				@csrf
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Nome</label>
					<input type="text" name="name" class="form-control form-control-sm">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Descrição</label>
					<input type="text" name="description" class="form-control form-control-sm">
				</div>

				<div class="form-group col-md-4 col-sm-12">
					<label class="label">Marca</label>
					<select type="text" name="marca_id" class="form-control form-control-sm">
						@foreach($marcas as $marca)
							<option value="{{$marca->id}}">{{$marca->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-4 col-sm-12">
					<label class="label">Categoria</label>
					<select type="text" name="categoria_id" class="form-control form-control-sm">
						@foreach($categorias as $categoria)
							<option value="{{$categoria->id}}">{{$categoria->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-4 col-sm-12">
					<label class="label">Sub categoria</label>
					<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
						@foreach($categorias as $categoria)
							<option value="{{$categoria->id}}">{{$categoria->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Preço</label>
					<input type="text" name="price" class="form-control form-control-sm">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Estoque mínimo</label>
					<input type="text" name="stock" class="form-control form-control-sm">
				</div>

				<div class="form-group col-md-12 col-sm-12">
					<label class="label">Imagem</label>
					<input type="file" name="imagem" class="form-control form-control-sm ">
				</div>
				<div class="col">
					<button type="submit" class=" btn btn-sm btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>	
</div>