
	@php $randId = rand(11111, 999999); @endphp

	<style>
		.filtred{
			padding: 2px 4px;
			border-radius: 10px;
			color: #000;
			background-color: #ccc;
			margin-right: 3px;
			margin-left: 3px;
			cursor: pointer;
		}
	</style>
	<div class="container-fluid my-4 body">
		<div class="row">
			<div class="col-md-12">	
				<nav aria-label="breadcrumb" class="my-2">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="{{route('estado.index')}}">Inicio</a></li>
						<li class="breadcrumb-item desable" aria-current="page"><a >Lista de estados</a></li>
					</ol>
				</nav>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 col-sm-12">
			
				<!--
				<div class="row">
					<div class="col-md-12" id="container_filtros{{$randId}}">
						<div class="card card-togle card-sistem" >

							<div class="card-header form-inline"  style="background-color: #E9ECEF;" >
								<div class="row" style="width: 100%;text-align: left;">
									<div class="col-md-1 col-sm-3" id="container_icon_filter{{$randId}}">
										<button type="button" class="btn btn-sm btn-outline-primary mb-sm-1" id="form_filtro{{$randId}}"><i class="fas fa-filter"></i></button>
									</div>
									<div class="col-md-11 col-sm-9 p-2" id="container_filtred{{$randId}}">
										
									</div>
								</div>
								
							</div>

							<div class="card-body" >
								<form class="" id="filtros{{$randId}}">
										@csrf
										<div class="row" >
											<div class="custom-control my-1 col-md-4 col-sm-12">
												<label class="label text-left" for="id">Cód</label>
												<input type="text" name="id" class="form-control form-control-sm filtro" id="id">
											</div>

											<div class="custom-control my-1 col-md-4 col-sm-12">
												<label class="label  text-left" for="nmEStado">Descrição</label>
												<input type="text" name="nmEStado" class="form-control form-control-sm filtro" id="nmEStado">
											</div>

											<div class="custom-control my-1 col-md-4 col-sm-12">
												<label class="label  text-left" for="sigla">Sigla</label>
												<input type="text" name="sigla" class="form-control form-control-sm filtro" id="sigla">
											</div>

											<div class="custom-control my-1 col-md-4 col-sm-12">
												<label class="label  text-left" for="ordem">Ordenar por</label>
												<select  name="ordem" class="form-control form-control-sm filtro" id="ordem">
													@php
														$ordem = [
															'nome_produto-ASC'=>'Nome produto AZ',
															'nome_produto-DESC'=>'Nome produto ZA',
														];
														foreach( $ordem as $key=>$val){
															@endphp
																<option value="{{$key}}">{{$val}}</option>
															@php

														}
													@endphp
													
												</select>
												
											</div>

											<div class="custom-control my-1 col-md-4 col-sm-12">
												<label class="label  text-left" for="limite">Limite</label>
												<input type="number" value="150" name="limite" class="form-control form-control-sm filtro" id="limite">
											</div>

										</div>
									
								</form>
							</div>

							<div class="card-footer bg-white form-inline"  >
								<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" onClick="pesquisar{{$randId}}();" id="form_search_produto{{$randId}}"><i class="fas fa-search"></i> Pesquisar</buttom>
								<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="exportar_relatorio{{$randId}}">Exportar para excel</buttom>
								<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="relatorio{{$randId}}">Relatório</buttom>
								<a href="{{route('estado.create')}}" onClick="cadastrar{{$randId}}(this);" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="cadastrar{{$randId}}"><i class="fas fa-plus"></i> Cadastrar</a>
								
							</div>

						</div>
					</div>
				</div>
				-->

				@php
					$fieldsForm = [
						[
							'label'     =>'Cód',
							'value'     =>'',
							'name'      =>'id',
							'class'     =>'',
							'onChange'  =>'',
							'onClick'   =>'',
							'type'      =>'text',
							'options'   =>[],

						],
						[
							'label'     =>'Descrição',
							'value'     =>'',
							'name'      =>'nmEStado',
							'class'     =>'',
							'onChange'  =>'',
							'onClick'   =>'',
							'type'      =>'text',
							'options'   =>[],

						],
						[
							'label'     =>'Sigla',
							'value'     =>'',
							'name'      =>'sigla',
							'class'     =>'',
							'onChange'  =>'',
							'onClick'   =>'',
							'type'      =>'text',
							'options'   =>[],

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
							'href'      =>''.route('estado.create').'',
							'class'     =>'btn btn-md btn-outline-primary mr-2 mb-sm-1',
							'style'     =>'',
							'id'        =>'form_cadastrar'.$randId,
							'icone'     =>'fas fa-plus',
							'label'     =>'Cadastrar',
						]
							
					];

					//dd($acoes);
					$callback 	= '';
				@endphp
				<div id="filtros{{$randId}}">
					@csrf
				</div>

				<x-form-filtro-relatorio
					:fieldsForm="$fieldsForm"
					:acoes="$acoes"
					:callback="$callback"

				/>

			</div>
			<div class="col-md-8 col-sm-12">

				<div class="card card-sistem" >

					<div class="card-header form-inline"  style="background-color: #E9ECEF;">
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
				</div>
			</div>
			
		</div>
	</div>
	<script type="text/javascript">
		
					
		const body = document.getElementById('container-laraval-body');
		if(!body){
			
			let url = window.location.href;
			if(url.indexOf('?')){

				
				url = url.split('?')
				let params =  url[1] ? url[1].split('&'): '';
				let objParam = {}
				if(Array.isArray(params) && params.length > 0){
					for(let i = 0; !(i == params.length); i++){
						let atual = params[i].split('=');
						if(Array.isArray(atual) && atual.length > 0){
							objParam[atual[0]] = atual[1] ? atual[1] : '';
						}
						
					}
				}
				let newParams = '?';
				objParam['isReload'] = 'true';
				for(let ob in objParam){
					if(String(ob) && String(objParam[ob])){
						newParams += '&'+ob+'='+objParam[ob];
					}
				}

				url = url[0]+newParams
			}
			console.log(url)
			window.location = url;
			
		}


		Utilitarios.modifyUrlWithoutReload('/estado/head', 'Estados')
		let idModalOptions = null;
		
		$('html body').delegate('#form_filtro{{$randId}}', 'click', function(ev){
			ev.preventDefault();
			//Utilitarios.toggleFiltro();
			togleFiltros();
		});	

		function pesquisar{{$randId}}(){
			let url = '/estado/index';

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

				Utilitarios.assistentAjaxModal('POST',url, 'HTML','NCM-Cadastrar', 'sm', '300px', null, data)
				//Utilitarios.toggleFiltro();
			}catch(ex){
					console.log('Erro: '+ex.message);
			}
		}


		function tributar{{$randId}}(element){
			
			try{
				let url = $(element).attr('href');
				let id = $(element).attr('idItem');
				let idModal= $(element).attr('idModal');
				// //
				//Utilitarios.fecharAssistente(idModalOptions{{$randId}});
				let data = new FormData();
				data.append('id', id)
				data.append('idAssistente', '')
				data.append('callBack', ''+btoa('pesquisar{{$randId}}();')+'')

				let token = $('html').find('#filtros{{$randId}}').find('input[name="_token"]').val()
				data.append('_token', token)

				Utilitarios.assistentAjaxModal('POST',url, 'HTML','NCM-Editar', 'sm', '300px', null, data)
				

			}catch(ex){
					console.log('Erro: '+ex.message);
			}
		}

		togleFiltros();
		pesquisar{{$randId}}()


	</script>