@php $randId = rand(11111, 99999); @endphp

<div class="row p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('produto.update', $registro->id)}}" method="post" class="form" id="form_{{$randId}}" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			
			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
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
					<label class="label">GTIN</label>
					<input type="text" name="ncm" class="form-control form-control-sm">
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
				<div class="form-group col-md-12 col-sm-12">
					@php
					
						$idCod = '01';
						$typeCod = 'number';
						$nameCod = 'idNcm';
						$labelCod = 'NCM';
						$idDescription = '02';
						$typeDescrption = 'text';
						$nameDescription = 'dsNcm';
						$labelDescription = 'Descrição';
						$valueDescription = "01";
						$valueCod = "Teste 01";
						$colCod = "2";
						$colDescription = "9";
						$searsh = "searshNcm".$randId."();";
					
					@endphp
					<x-controll-filter
						:idCod="$idCod"
						:typeCod="$typeCod"
						:nameCod="$nameCod"
						:labelCod="$labelCod"
						:idDescription="$idDescription"
						:typeDescrption="$typeDescrption"
						:nameDescription="$nameDescription"
						:labelDescription="$labelDescription"
						:valueDescription="$valueDescription"
						:valueCod="$valueCod"
						:colCod="$colCod"
						:colDescription="$colDescription"
						:searsh="$searsh"

					/>
				</div>
			</div>
			

			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados para venda</h5>
		<hr/>


		<div class="row">
			<div class="form-group col-md-6 col-sm-12">
				<label class="label">Preço de custo</label>
				<input type="text" value="0"  name="selling_price" class="form-control form-control-sm">
			</div>

			<div class="form-group col-md-6 col-sm-12">
				<label class="label">Preço de venda</label>
				<input type="text" value="{{$registro->price}}" name="price" class="form-control form-control-sm">
			</div>

			<!--<div class="form-group col-md-6 col-sm-12">
				<label class="label">Estoque mínimo</label>
				<input type="text" name="stock" class="form-control form-control-sm">
			</div> -->
		</div>

		<div class="row">
				<div class="form-group col-md-4 col-sm-12">
					<label class="label">Venda sem estoque</label>
					<select type="text" name="sale_without_stok" id="sale_without_stok" class="form-control form-control-sm">						
						<option value="no">No</option>
						<option value="yes">Yes</option>						
					</select>
				</div>

				<div class="form-group col-md-4 col-sm-12">
					<label class="label">Entrada bloqueada</label>
					<select type="text" name="blokade_stok" id="blokade_stok" class="form-control form-control-sm">						
						<option value="no">No</option>
						<option value="yes">Yes</option>						
					</select>
				</div>

				<div class="form-group col-md-4 col-sm-12">
					<label class="label">Venda fracionada</label>
					<select type="text" name="fracioned_sale" id="fracioned_sale" class="form-control form-control-sm">						
						<option value="no">No</option>
						<option value="yes">Yes</option>						
					</select>
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
<script>
	const assistente = '{{$idAssistente}}';
	$("#tabs{{$randId}}").tabs()
	//edita ou salva um produto
	$('html body').delegate('form#form_{{$randId}}','submit', function(ev){
		ev.preventDefault();
		try{

			let url = $(this).attr('action');
			let id = $(this).attr('id');

			let form = new FormData($(this)[0]);
			$.ajax({
				url:url,
				type:'POST',
				dataType:'json',
				data:form,
				processData:false,
				contentType:false,
				success:function(response){
					console.log(response);
					console.log(response.mensagem.id);

					if(response.mensagem.hasOwnProperty('id') || response.mensagem == true){
						Utilitarios.fecharAssistente(assistente);
						Utilitarios.assistenteMensage('Registrado com sucesso');
						@php echo base64_decode($callBack) @endphp

					}else{

						Utilitarios.assistenteMensage('Erro ao atuaolizar registro', 'warning', 'Erro');


					}
				},
				error:function(response, status, error){
					//console.log(response, status, error)
					console.log(response.responseJSON);
					let objErros = response.responseJSON.errors
					let msg = 'Atenção, os seguintes erros foram encontrados: <br/>';
					for (let prop in objErros){
						msg+='<strong>'+prop+': </strong>'+objErros[prop]+'<br/>';
					}

					Utilitarios.assistenteMensage(msg, 'warning', 'Erro');
				}


			})

		}catch(ex){

			console.log(ex.message);
		}

		
	});

	function searshNcm{{$randId}}(){
		try{
			let url = '/ncm/head';
			//let idModal= $(element).attr('idModal');
			// //
			//Utilitarios.fecharAssistente(idModalOptions{{$randId}});
			//let data = new FormData();
			//data.append('id', id)
			//data.append('idAssistente', '')
			//data.append('callBack', ''+callBack{{$randId}}+'')

			//let token = $('html').find('#lista{{$randId}}').find('input[name="_token"]').val()
			//data.append('_token', token)

			//Utilitarios.assistentAjaxModal('POST',url, 'HTML','NCM-Editar', 'sm', '300px', null, data)
			Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produtos', 'sm', '700px', null, null)
		}catch(ex){
				console.log('Erro: '+ex.message);
		}
	}
</script>