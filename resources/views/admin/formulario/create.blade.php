@php 
	$randId = rand(11111, 99999);


	$fieldsForm = [
		[
            'label'     =>'Nome',
            'value'     =>'',
            'name'      =>'name',
            'class'     =>'',
            'onChange'  =>'',
            'onClick'   =>'',
            'type'      =>'text',
            'options'   =>[],
			'classContainer'=>'mb-3 form-group col-md-6 col-sm-12',

        ],
		[
            'label'     =>'Descrição',
            'value'     =>'',
            'name'      =>'description',
            'class'     =>'',
            'onChange'  =>'',
            'onClick'   =>'',
            'type'      =>'text',
            'options'   =>[],
			'classContainer'=>'mb-3 form-group col-md-6 col-sm-12'

        ],
	];

	
@endphp


<div class="row p-3">
	<div class="col-md-12 col-sm-12">
		<form action="{{route('produto.store')}}" method="post" class="form " id="form_{{$randId}}" enctype="multipart/form-data">
			@csrf

			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados Básicos</h5>
			<hr/>
			<div class="row  mt-5">
				@if(is_array($fieldsForm) && count($fieldsForm) > 0)
					@for($i=0; !($i == count($fieldsForm)); $i++)

						@php 
						$label      =   $fieldsForm[$i]['label']            ?? ''; 
						$value      =   $fieldsForm[$i]['value']            ?? ''; 
						$name       =   $fieldsForm[$i]['name']             ?? ''; 
						$class      =   $fieldsForm[$i]['class']            ?? ''; 
						$onChange   =   $fieldsForm[$i]['onChange']         ?? ''; 
						$onClick    =   $fieldsForm[$i]['onClick']          ?? ''; 
						$type       =   $fieldsForm[$i]['type']             ?? ''; 
						$options    =   $fieldsForm[$i]['options']          ?? []; 
						$id         =   $fieldsForm[$i]['name'].$randId     ?? ''; 
						$classContainer = $fieldsForm[$i]['classContainer'] ?? '';

						@endphp

						@switch($type)
							@case('select')
								<x-select
									:label="$label"
									:value="$value"
									:name="$name"
									:class="$class"
									:onChange="$onChange"
									:onClick="$onClick"
									:type="$type"
									:options="$options"
									:id="$id"
									:classContainer="$classContainer"
								
								/>
							@break

							@case('radio')

							@break

							@case('textarea')

							@break

							@case('checkbox')

							@break
							@default
								<x-input
									:label="$label"
									:value="$value"
									:name="$name"
									:class="$class"
									:onChange="$onChange"
									:onClick="$onClick"
									:type="$type"
									:id="$id"
									:classContainer="$classContainer"
								
								/>
								
							

						@endswitch
						
					@endfor

				@endif

			</div>
			<div class="row">
				<div class="col-md-6 col-sm-12">
					@php
					
						$idCod = 'marca_id';
						$typeCod = 'number';
						$nameCod = 'marca_id';
						$labelCod = 'Cód';
						$idDescription = 'name_marca';
						$typeDescrption = 'text';
						$nameDescription = 'name_marca';
						$labelDescription = 'Marca';
						$valueDescription = "";
						$valueCod = "";
						$colCod = "2";
						$colDescription = "9";
						$searsh = "searshMarca".$randId."();";
					
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

				<div class=" col-md-6 col-sm-12">
					@php
					
						$idCod = 'unidade_id';
						$typeCod = 'number';
						$nameCod = 'unidade_id';
						$labelCod = 'Cód';
						$idDescription = 'name_unidade';
						$typeDescrption = 'text';
						$nameDescription = 'name_unidade';
						$labelDescription = 'Unidade';
						$valueDescription = "";
						$valueCod = "";
						$colCod = "2";
						$colDescription = "9";
						$searsh = "searshUnidade".$randId."();";
					
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
			<div class="row">
				<div class="col-md-6 col-sm-12">
					@php
					
						$idCod = 'categoria_id';
						$typeCod = 'number';
						$nameCod = 'categoria_id';
						$labelCod = 'Cód';
						$idDescription = 'name_categoria';
						$typeDescrption = 'text';
						$nameDescription = 'name_categoria';
						$labelDescription = 'Categoria';
						$valueDescription = "";
						$valueCod = "";
						$colCod = "2";
						$colDescription = "9";
						$searsh = "searshCategoria".$randId."();";
					
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

				<div class="col-md-6 col-sm-12">
					@php
					
						$idCod = 'sub_categoria_id';
						$typeCod = 'number';
						$nameCod = 'sub_categoria_id';
						$labelCod = 'Cód';
						$idDescription = 'name_subcategoria';
						$typeDescrption = 'text';
						$nameDescription = 'name_subcategoria';
						$labelDescription = 'Subcategoria';
						$valueDescription = "";
						$valueCod = "";
						$colCod = "2";
						$colDescription = "9";
						$searsh = "searshSubCategoria".$randId."();";
					
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
			@php
			
				$fieldsForm = [
					[
						'label'     =>'EAN',
						'value'     =>'',
						'name'      =>'ean',
						'class'     =>'',
						'onChange'  =>'',
						'onClick'   =>'',
						'type'      =>'text',
						'options'   =>[],
						'classContainer'=>'mb-3 col-md-6 col-sm-12'

					],
					[
						'label'     =>'Origem',
						'value'     =>'',
						'name'      =>'origem',
						'class'     =>'',
						'onChange'  =>'',
						'onClick'   =>'',
						'type'      =>'select',
						'options'   =>[
							'0'=>'Nacional',
							
						],
						'classContainer'=>'mb-3 col-md-6 col-sm-12'

					],
					[
						'label'     =>'Imagem',
						'value'     =>'',
						'name'      =>'imagem',
						'class'     =>'',
						'onChange'  =>'',
						'onClick'   =>'',
						'type'      =>'file',
						'options'   =>[],
						'classContainer'=>'col-md-6 col-sm-12'

					]
				];
			@endphp

			

			<div class="row">
				@if(is_array($fieldsForm) && count($fieldsForm) > 0)
					@for($i=0; !($i == count($fieldsForm)); $i++)

						@php 
						$label      =   $fieldsForm[$i]['label']            ?? ''; 
						$value      =   $fieldsForm[$i]['value']            ?? ''; 
						$name       =   $fieldsForm[$i]['name']             ?? ''; 
						$class      =   $fieldsForm[$i]['class']            ?? ''; 
						$onChange   =   $fieldsForm[$i]['onChange']         ?? ''; 
						$onClick    =   $fieldsForm[$i]['onClick']          ?? ''; 
						$type       =   $fieldsForm[$i]['type']             ?? ''; 
						$options    =   $fieldsForm[$i]['options']          ?? []; 
						$id         =   $fieldsForm[$i]['name'].$randId     ?? ''; 
						$classContainer = $fieldsForm[$i]['classContainer'] ?? '';

						@endphp

						@switch($type)
							@case('select')
								<x-select
									:label="$label"
									:value="$value"
									:name="$name"
									:class="$class"
									:onChange="$onChange"
									:onClick="$onClick"
									:type="$type"
									:options="$options"
									:id="$id"
									:classContainer="$classContainer"
								
								/>
							@break

							@case('radio')

							@break

							@case('textarea')

							@break

							@case('checkbox')

							@break
							@default
								<x-input
									:label="$label"
									:value="$value"
									:name="$name"
									:class="$class"
									:onChange="$onChange"
									:onClick="$onClick"
									:type="$type"
									:id="$id"
									:classContainer="$classContainer"
								
								/>
								
							

						@endswitch
						
					@endfor

				@endif
				<div class="col-md-6 col-sm-12">
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

			<!--<div class="row  mt-5">
				<div class="form-group col-md-6 col-sm-12">
					<label class="label" for="name">Nome</label>
					<input type="text" name="name" id="name" class="form-control form-control-sm">
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
			</div>-->

			


			<h5 class="mt-3 text-primary" style="text-transform:uppercase;font-weight: bolder;">Dados para venda</h5>
			<hr/>


			<div class="row">
				@php
				
					$fieldsForm = [
						[
							'label'     =>'Preço de custo',
							'value'     =>'',
							'name'      =>'selling_price',
							'class'     =>'',
							'onChange'  =>'',
							'onClick'   =>'',
							'type'      =>'text',
							'options'   =>[],
							'classContainer'=>'mb-3 col-md-6 col-sm-12'

						],
						[
							'label'     =>'Preço de venda',
							'value'     =>'',
							'name'      =>'price',
							'class'     =>'',
							'onChange'  =>'',
							'onClick'   =>'',
							'type'      =>'text',
							'options'   =>[],
							'classContainer'=>'mb-3 col-md-6 col-sm-12'

						]
					];
				@endphp
				
				@if(is_array($fieldsForm) && count($fieldsForm) > 0)
					@for($i=0; !($i == count($fieldsForm)); $i++)

						@php 
						$label      =   $fieldsForm[$i]['label']            ?? ''; 
						$value      =   $fieldsForm[$i]['value']            ?? ''; 
						$name       =   $fieldsForm[$i]['name']             ?? ''; 
						$class      =   $fieldsForm[$i]['class']            ?? ''; 
						$onChange   =   $fieldsForm[$i]['onChange']         ?? ''; 
						$onClick    =   $fieldsForm[$i]['onClick']          ?? ''; 
						$type       =   $fieldsForm[$i]['type']             ?? ''; 
						$options    =   $fieldsForm[$i]['options']          ?? []; 
						$id         =   $fieldsForm[$i]['name'].$randId     ?? ''; 
						$classContainer = $fieldsForm[$i]['classContainer'] ?? '';

						@endphp

						@switch($type)
							@case('select')
								<x-select
									:label="$label"
									:value="$value"
									:name="$name"
									:class="$class"
									:onChange="$onChange"
									:onClick="$onClick"
									:type="$type"
									:options="$options"
									:id="$id"
									:classContainer="$classContainer"
								
								/>
							@break

							@case('radio')

							@break

							@case('textarea')

							@break

							@case('checkbox')

							@break
							@default
								<x-input
									:label="$label"
									:value="$value"
									:name="$name"
									:class="$class"
									:onChange="$onChange"
									:onClick="$onClick"
									:type="$type"
									:id="$id"
									:classContainer="$classContainer"
								
								/>
								
							

						@endswitch
						
					@endfor

				@endif

				<!--<div class="form-group col-md-6 col-sm-12">
					<label class="label">Preço de custo</label>
					<input type="text" name="selling_price" class="form-control form-control-sm">
				</div>

				<div class="form-group col-md-6 col-sm-12">
					<label class="label">Preço de venda</label>
					<input type="text" name="price" class="form-control form-control-sm">
				</div>-->
			</div>

			<div class="row">
				@php
					
					$fieldsForm = [
						[
							'label'     =>'Venda sem estoque',
							'value'     =>'',
							'name'      =>'sale_without_stok',
							'class'     =>'',
							'onChange'  =>'',
							'onClick'   =>'',
							'type'      =>'select',
							'options'   =>[
								'yes'=> 'Sim',
								'no'=> 'Não',
							],
							'classContainer'=>'mb-3 col-md-4 col-sm-12'

						],
						[
							'label'     =>'Entrada bloqueada',
							'value'     =>'',
							'name'      =>'blokade_stok',
							'class'     =>'',
							'onChange'  =>'',
							'onClick'   =>'',
							'type'      =>'select',
							'options'   =>[
								'yes'=> 'Sim',
								'no'=> 'Não',
							],
							'classContainer'=>'mb-3 col-md-4 col-sm-12'

						],
						[
							'label'     =>'Venda fracionada',
							'value'     =>'',
							'name'      =>'fracioned_sale',
							'class'     =>'',
							'onChange'  =>'',
							'onClick'   =>'',
							'type'      =>'select',
							'options'   =>[
								'yes'=> 'Sim',
								'no'=> 'Não',
							],
							'classContainer'=>'mb-3 col-md-4 col-sm-12'

						]
					];
				@endphp
				
				@if(is_array($fieldsForm) && count($fieldsForm) > 0)
					@for($i=0; !($i == count($fieldsForm)); $i++)

						@php 
						$label      =   $fieldsForm[$i]['label']            ?? ''; 
						$value      =   $fieldsForm[$i]['value']            ?? ''; 
						$name       =   $fieldsForm[$i]['name']             ?? ''; 
						$class      =   $fieldsForm[$i]['class']            ?? ''; 
						$onChange   =   $fieldsForm[$i]['onChange']         ?? ''; 
						$onClick    =   $fieldsForm[$i]['onClick']          ?? ''; 
						$type       =   $fieldsForm[$i]['type']             ?? ''; 
						$options    =   $fieldsForm[$i]['options']          ?? []; 
						$id         =   $fieldsForm[$i]['name'].$randId     ?? ''; 
						$classContainer = $fieldsForm[$i]['classContainer'] ?? '';

						@endphp

						@switch($type)
							@case('select')
								<x-select
									:label="$label"
									:value="$value"
									:name="$name"
									:class="$class"
									:onChange="$onChange"
									:onClick="$onClick"
									:type="$type"
									:options="$options"
									:id="$id"
									:classContainer="$classContainer"
								
								/>
							@break

							@case('radio')

							@break

							@case('textarea')

							@break

							@case('checkbox')

							@break
							@default
								<x-input
									:label="$label"
									:value="$value"
									:name="$name"
									:class="$class"
									:onChange="$onChange"
									:onClick="$onClick"
									:type="$type"
									:id="$id"
									:classContainer="$classContainer"
								
								/>
								
							

						@endswitch
						
					@endfor

				@endif
				<!-- 
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
				</div> -->

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
Vr frete *
outras despesas *

Dados de tributação
	Nomenclatura Comum do Mercosul (NCM);
	Código Especificador da Substituição Tributária (CEST);
	Imposto sobre Circulação de Mercadorias e Serviços (ICMS);
	Imposto sobre Produtos Industrializados (IPI);
	Programa de Integração Social (PIS);
	Contribuição para o Financiamento da Seguridade Social (Cofins).

	Preço Compra = (Preço Fábrica – Descontos do Fornecedor)

Embalagem (em cm){

	Largura,
	Altura,
	profundidade
}

Kit{
	isKit
	desmenbra iten do kit no momento da venda
	Controle de estoque{
		Movimentar estoque somente do kit
		Movimentar estoque dos produtos do kit (Materia - prima)
	},
	qtdItens Kit,
}

 -->



<script>
	//edita ou salva um produto
	$('html body').delegate('form#form_{{$randId}}','submit', function(ev){

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

					Utilitarios.assistenteMensageAlert(msg, 'warning');
				}


			})

		}catch(ex){

			console.log(ex.message);
		}

		ev.preventDefault();
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