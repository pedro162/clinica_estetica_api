@extends('layouts.app')
@section('content')

@php $randId = rand(11111, 999999); @endphp
<div class="container-fluid my-4 body">
	<div class="row">
		<div class="col-md-12">	
			<nav aria-label="breadcrumb" class="my-2">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active"><a href="{{route('marca.index')}}">Inicio</a></li>
					<li class="breadcrumb-item desable" aria-current="page"><a >Lista de marcas</a></li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-12">
		
			@php
				$fieldsForm = [
					[
						'label'     =>'Cód',
						'value'     =>'',
						'name'      =>'codigo_marca',
						'class'     =>'',
						'onChange'  =>'',
						'onClick'   =>'',
						'type'      =>'text',
						'options'   =>[],
						'classContainer' =>'col-md-6 col-sm-12'

					],
					[
						'label'     =>'Descrição',
						'value'     =>'',
						'name'      =>'nome_marca',
						'class'     =>'',
						'onChange'  =>'',
						'onClick'   =>'',
						'type'      =>'text',
						'options'   =>[],
						'classContainer' =>'col-md-6 col-sm-12'

					],
					[
						'label'     =>'Ordenar por',
						'value'     =>'',
						'name'      =>'ordem',
						'class'     =>'',
						'onChange'  =>'',
						'onClick'   =>'',
						'type'      =>'select',
						'options'   =>[
							'id-ASC'=>'Cód',
							'id-DESC'=>'Cód',
							'nmEStado-ASC'=>'Descrição',
							'nmEStado-DESC'=>'Descrição',
						],
						'classContainer' =>'col-md-6 col-sm-12'

					],
					[
						'label'     =>'LIMIT',
						'value'     =>'150',
						'name'      =>'limite',
						'class'     =>'',
						'onChange'  =>'',
						'onClick'   =>'',
						'type'      =>'number',
						'options'   =>[],
						'classContainer' =>'col-md-6 col-sm-12'

					],


					
				];

				$acoes 		= [

					[
						'type'      =>'buttom',
						'onClick'   =>'pesquisar'.$randId.'();',
						'href'      =>'',
						'class'     =>'btn btn-md btn-outline-primary mr-2 mb-sm-1',
						'style'     =>'',
						'id'        =>'form_search'.$randId,
						'icone'     =>'fas fa-search',
						'label'     =>'Pesquisar',
					],
					[
						'type'      =>'link',
						'onClick'   =>'cadastrar'.$randId.'(this);',
						'href'      =>''.route('categoria.create').'',
						'class'     =>'btn btn-md btn-outline-primary mr-2 mb-sm-1',
						'style'     =>'',
						'id'        =>'form_cadastrar'.$randId,
						'icone'     =>'fas fa-plus',
						'label'     =>'Cadastrar',
					]
						
				];

				//dd($acoes);
				$callback 	= '';

				$idContainer = '';
				$idAreaFiltrados = 'container_filtred'.$randId;
				
			@endphp
			<div id="filtros{{$randId}}">
				@csrf
			

				<x-form-filtro-relatorio
					:fieldsForm="$fieldsForm"
					:acoes="$acoes"
					:callback="$callback"
					:idContainer="$idContainer"
					:idAreaFiltrados="$idAreaFiltrados"

				/>
			</div>

		</div>
		<div class="col-md-9 col-sm-12">

			<div class="card card-sistem" >

				<div class="card-header form-inline"  style="background-color: #E9ECEF;height: 60px !important">
					<div class="row" style="width: 100%;text-align: left;">
						<div class="col-md-12 col-sm-12">
							<h5 class="text-primary p-1" style="text-transform:uppercase;font-weight: bolder;">Relatório</h5>
						</div>
						
					</div>
							
				</div>
				<div class="card-body" style="display: block !important;">
					<div id="response-request{{$randId}}">

					</div>
				</div>
				<div class="card-footer bg-white form-inline" style="display: block !important;">
					@php
							$acoesTable = [
								[
									'type'=>'link',
									'onClick'=>'teste'.$randId.'();',
									'href'=>'faf',
									'class'=>'btn btn-md btn-outline-primary mr-2 mb-sm-1',
									'style'=>'',
									'id'=>'',
									'icone'=>'fas fa-plus',
									'label'=>'Teste',
								],
							];				
					@endphp

					@for($i=0; !($i == count($acoesTable)); $i++)
							@php
								$atual 		= $acoesTable[$i];
								$type 		= $atual['type'] 		?? '';
								$onClick 	= $atual['onClick'] 	?? '';
								$href 		= $atual['href'] 		?? '';
								$class 		= $atual['class'] 		?? '';
								$style 		= $atual['style'] 		?? '';
								$id 		= $atual['id'] 			?? '';
								$icone 		= $atual['icone'] 		?? '';
								$label 		= $atual['label'] 		?? '';

							@endphp
						<x-link
							:type="$type"
							:onClick="$onClick"
							:href="$href"
							:class="$class"
							:style="$style"
							:id="$id"
							:icone="$icone"
							:label="$label"
						/>
					@endfor
				</div>
			</div>
		</div>
		
	</div>
</div>
	<script type="text/javascript">
		Utilitarios.modifyUrlWithoutReload('/categoria/head', 'Categorias')
		let idModalOptions = null;
		
		$('html body').delegate('#form_filtro{{$randId}}', 'click', function(ev){
			ev.preventDefault();
			//Utilitarios.toggleFiltro();
			togleFiltros();
		});	

		function pesquisar{{$randId}}(){
			let url = '/categoria/index';

			let objResponse = '#response-request{{$randId}}';
			//Utilitarios.assistentAjax('GET',url, 'HTML', objResponse)
			//togleFiltros();
			carregarItens{{$randId}}('POST', url, 'HTML', objResponse)

		}

		function togleFiltros(){
			$('html').find('#container_filtros{{$randId}}').find('.card').find('.card-body').toggle('fast');
			$('html').find('#container_filtros{{$randId}}').find('.card').find('.card-footer').toggle('fast');
			//filtros{{$randId}}

		}

		function carregarItens{{$randId}}(type, url, dataType, objResponse){

			let filtro = montarFiltro{{$randId}}();
			let formData = new FormData();

			let token = $('html').find('#filtros{{$randId}}').find('input[name="_token"]').val()
			formData.append('_token', token)
			formData.append('callBack', btoa('carregarItens{{$randId}}("'+type+'", "'+url+'", "'+dataType+'", "'+objResponse+'");'))

			formData.append('idTable', 'lista{{$randId}}') // id para a tabela
			formData.append('selectorsLine', true) // para exibir os checkbox

			if(Array.isArray(filtro) && filtro.length > 0){
				let escuta = false;
				
				for(let i=0; !(i == filtro.length); i++){
					let condition = filtro[i].hasOwnProperty('name') && filtro[i].hasOwnProperty('value')
					if(condition == true){
						escuta = true;
					
						formData.append(filtro[i].name, filtro[i].value)
					}
				}

				if(escuta){
					
					exibeFiltroHead{{$randId}}();
					
				}
			}
			objResponse = $('html body').find('' +objResponse+ '');
			Utilitarios.assistentAjax(type, url, dataType, objResponse, null, formData)
		}

		function montarFiltro{{$randId}}(){
			
			let dados = [];
			$('html').find('#filtros{{$randId}}').find('.filtro').each(function(){
				let atual 	= $(this);
				let name 	= String(atual.attr('name')).trim();
				let valor 	= String(atual.val()).trim()
				let id 		= String(atual.attr('id').trim())
				let label 	= String($('html').find('#filtros{{$randId}}').find('label[for="'+id+'"]').text()).trim();

				if(valor.length > 0 && valor != 'null' && valor != 'undefined'){
					let obj ={
						'label': label,
						'name': name,
						'id': id,
						'value': valor
					}
					dados.push(obj)
				}
			})
			
			return dados;
		}


		function exibeFiltroHead{{$randId}}(containerSlector = '#container_filtred{{$randId}}'){
			let filtro = montarFiltro{{$randId}}();
		
			if(Array.isArray(filtro) && filtro.length > 0){
				let filtros_head = '';

				for(let i=0; !(i == filtro.length); i++){
					let condition = filtro[i].hasOwnProperty('name') && filtro[i].hasOwnProperty('value')
					if(condition == true){
						
						let param = filtro[i].id;
						filtros_head += `<span onClick="try{removerFiltro{{$randId}}('${'#'+param}');}catch(e){console.log(e)}" class="filtred">${filtro[i].label}: ${filtro[i].value}</span>`;
						console.log('aqui 03')
					}
				}
				$('html').find(containerSlector).html(filtros_head)
				return true;

			}
			$('html').find(containerSlector).html('')
			return false;
		}


		function removerFiltro{{$randId}}(selectorImput){
			
			$('html').find(selectorImput).val('');
			montarFiltro{{$randId}}()
			exibeFiltroHead{{$randId}}(containerSlector = '#container_filtred{{$randId}}')
			
		}
		
		function cadastrar{{$randId}}(element){
			try{
				let url = $(element).attr('href');
				let id = $(element).attr('idItem');
				let idModal= $(element).attr('idModal');
				
				//Utilitarios.fecharAssistente(idModalOptions{{$randId}});
				let data = new FormData();
				data.append('id', id)
				data.append('idAssistente', '')
				data.append('callBack', ''+btoa('pesquisar{{$randId}}();')+'')

				let token = $('html').find('#filtros{{$randId}}').find('input[name="_token"]').val()
				data.append('_token', token)

				Utilitarios.assistentAjaxModal('POST',url, 'HTML','Categoria - Cadastrar', 'sm', '200px', null, data)
				//Utilitarios.toggleFiltro();
			}catch(ex){
					console.log('Erro: '+ex.message);
			}
		}
		//--- ids da tabela
		//let ids = Utilitarios.selecionadosTable('lista{{$randId}}');
		//console.log(ids);

		function teste{{$randId}}(){
			let ids = Utilitarios.selecionadosTable('lista{{$randId}}');
			console.log(ids);
		}
		
		togleFiltros();
		pesquisar{{$randId}}()
		
	</script>
@endsection

