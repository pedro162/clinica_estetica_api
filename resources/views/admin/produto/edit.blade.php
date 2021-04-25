@php $randId = rand(11111, 99999); @endphp

<div class="container">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('produto.update', $registro->id)}}" method="post" class="form row p-5" id="form_produto_atualizar" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Nome</label>
					<input type="text" name="name" class="form-control form-control-sm" value="{{$registro->name}}">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Descrição</label>
					<input type="text" name="description" class="form-control form-control-sm" value="{{$registro->description}}">
				</div>

				<div class="form-group col-md-4 col-sm-12">
					<label class="label">Marca</label>
					<select type="text" name="marca_id" class="form-control form-control-sm">
						@foreach($marcas as $marca)
							<option {{ ($registro->marca_id == $marca->id) ? 'selected' : ''}} value="{{$marca->id}}">{{$marca->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-4 col-sm-12">
					<label class="label">Categoria</label>
					<select type="text" name="categoria_id" class="form-control form-control-sm">
						@foreach($categorias as $categoria)
							<option value="{{$categoria->id}}" {{ ( $registro->categoria_id_pri == $categoria->id ? 'selected' : '')}} >{{$categoria->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-4 col-sm-12">
					<label class="label">Sub categoria</label>
					<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
						@foreach($categorias as $categoria)
							<option value="{{$categoria->id}}"  {{ ( $registro->categoria_id_sec == $categoria->id ? 'selected' : '')}} >{{$categoria->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Preço</label>
					<input value="{{$registro->price}}" type="text" name="price" class="form-control form-control-sm">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Estoque mínimo</label>
					<input value="{{$registro->stock}}" type="text" name="stock" class="form-control form-control-sm">
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
<script>
	$("#tabs{{$randId}}").tabs()
	
</script>