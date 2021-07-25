
<div class="row mb-5 p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('produto.store')}}" method="post" class="form " id="form_produto_cadastrar" enctype="multipart/form-data">
			@csrf

			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			<hr/>

			<div class="row  mt-5">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Nome</label>
					<input type="text" name="name" class="form-control form-control-sm">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Descrição</label>
					<input type="text" name="description" class="form-control form-control-sm">
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Marca</label>
					<select type="text" name="marca_id" class="form-control form-control-sm">
						@foreach($marcas as $marca)
							<option value="{{$marca->id}}">{{$marca->name}}</option>
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
							<option value="{{$categoria->id}}">{{$categoria->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Sub categoria</label>
					<select type="text" name="sub_categoria_id" class="form-control form-control-sm">
						@foreach($categorias as $categoria)
							<option value="{{$categoria->id}}">{{$categoria->name}}</option>
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

			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados para venda</h5>
			<hr/>


			<div class="row">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Preço de custo</label>
					<input type="text" name="selling_price" class="form-control form-control-sm">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Preço de venda</label>
					<input type="text" name="price" class="form-control form-control-sm">
				</div>

				<!--<div class="form-group col-md-6 col-sm-12">
					<label class="label">Estoque mínimo</label>
					<input type="text" name="stock" class="form-control form-control-sm">
				</div> -->
			</div>

			<div class="row">
				<div class="custom-control custom-checkbox col-md-4 col-sm-12">
					
					<input type="checkbox" name="sale_without_stok" class="custom-control-input" id="sale_without_stok"/>
					<label class="custom-control-label" for="sale_without_stok">Venda sem estoque</label>
				</div>

				<div class="custom-control custom-checkbox col-md-4 col-sm-12">
					
					<input type="checkbox" name="blokade_stok" class="custom-control-input" id="blokade_stok"/>
					<label class="custom-control-label"  for="blokade_stok">Bloqueio entrada de estoque</label>
				</div>

				<div class="custom-control custom-checkbox col-md-4 col-sm-12">
					
					<input type="checkbox" name="fracioned_sale" class="custom-control-input" id="fracioned_sale"/>
					<label class="custom-control-label" for="fracioned_sale">Venda fracionada</label>
				</div>

			</div>

			<div class="row">
				<div class="col-md-8 col-sm-12">
				</div>
				<div class="col-md-4 col-sm-12" style="text-align: right;">
					<button type="submit" class=" btn btn-md btn-primary"><b>Salvar</b></button>
				</div>
			</div>
		</form>
	</div>
</div>	

<!--
Nome do produto
Preço de custo
Preço de venda
Referências = EAN.
Unidade
Categorização

Dados de tributação
	Nomenclatura Comum do Mercosul (NCM);
	Código Especificador da Substituição Tributária (CEST);
	Imposto sobre Circulação de Mercadorias e Serviços (ICMS);
	Imposto sobre Produtos Industrializados (IPI);
	Programa de Integração Social (PIS);
	Contribuição para o Financiamento da Seguridade Social (Cofins).

	Preço Compra = (Preço Fábrica – Descontos do Fornecedor)

 -->

<script>
	//edita ou salva um produto
	$('html body').delegate('form#form_produto_cadastrar, form#form_produto_atualizar','submit', function(ev){

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

						Utilitarios.assistenteMensageAlert('Registrado com sucesso');

					}else{

						Utilitarios.assistenteMensageAlert('Erro ao atuaolizar registro', 'warning');

						
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

					Utilitarios.assistenteMensageAlert(msg, 'warning');
				}


			})

		}catch(ex){

			console.log(ex.message);
		}

		ev.preventDefault();
});
</script>