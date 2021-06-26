@php $randId = rand(11111, 99999); @endphp

<div class="container">
	<div class="row mb-5">
		<div class="col">
			<form action="{{route('produto.update', $registro->id)}}" method="post" class="form" id="form_produto_atualizar" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				
				<h2 class="mt-5 text-primary">Dados Básicos</h2>
				<hr/>

				<div class="row mt-5" >
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Nome</label>
						<input type="text" name="name" class="form-control form-control-sm" value="{{$registro->name}}">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Descrição</label>
						<input type="text" name="description" class="form-control form-control-sm" value="{{$registro->description}}">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Marca</label>
						<select type="text" name="marca_id" class="form-control form-control-sm">
							@foreach($marcas as $marca)
								<option {{ ($registro->marca_id == $marca->id) ? 'selected' : ''}} value="{{$marca->id}}">{{$marca->name}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
							<label class="label">Unidade</label>
							<input type="text" name="unidade" class="form-control form-control-sm">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Categoria</label>
						<select type="text" name="categoria_id" class="form-control form-control-sm">
							@foreach($categorias as $categoria)
								<option value="{{$categoria->id}}" {{ ( $registro->categoria_id_pri == $categoria->id ? 'selected' : '')}} >{{$categoria->name}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Sub categoria</label>
						<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
							@foreach($categorias as $categoria)
								<option value="{{$categoria->id}}"  {{ ( $registro->categoria_id_sec == $categoria->id ? 'selected' : '')}} >{{$categoria->name}}</option>
							@endforeach
						</select>
					</div>

				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">EAN</label>
						<input type="text" name="ean" class="form-control form-control-sm">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">NCM</label>
						<input type="text" name="ncm" class="form-control form-control-sm">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Preço de custo</label>
						<input value="{{$registro->price}}" type="text" name="price_custo" class="form-control form-control-sm">
					</div>

					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Estoque mínimo</label>
						<input value="{{$registro->stock}}" type="text" name="stock" class="form-control form-control-sm">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Origem</label>
						<select type="text" name="origem" class="form-control form-control-sm">						
							<option value=""></option>						
						</select>
					</div>


					<div class="form-group col-md-6 col-sm-12">
						<label class="label">Imagem</label>
						<input type="file" name="imagem" class="form-control form-control-sm ">
					</div>
				</div>

				<div class="row">

					<div class="col-md-8 col-sm-12">
					</div>
					<div class="col-md-4 col-sm-12" style="text-align: right;">
						<button type="submit" class=" btn btn-md btn-primary">Salvar</button>
					</div>
				</div>
			</form>
		</div>
	</div>	
</div>
<script>
	$("#tabs{{$randId}}").tabs()
	
</script>