
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
		<div class="col-md-12">	
			<nav aria-label="breadcrumb" class="my-2">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active"><a href="{{route('produto.index')}}">Inicio</a></li>
					<li class="breadcrumb-item desable" aria-current="page"><a >Lista de ncm</a></li>
				</ol>
			</nav>
		</div>
		<div class="col-md-12" id="container_filtros{{$randId}}">
			<div class="card card-togle" >

				<div class="card-header bg-white form-inline">
					<div class="row" style="width: 100%;text-align: left;">
						<div class="col-md-1 col-sm-12" id="container_icon_filter{{$randId}}">
							<button type="button" class="btn btn-sm btn-outline-primary mb-sm-1" id="form_filtro{{$randId}}"><i class="fas fa-filter"></i></button>
						</div>
						<div style="box-sizing: border-box;" class="col-md-11 col-sm-12 p-2" id="container_filtred{{$randId}}">
						</div>
					</div>
					
				</div>

				<div class="card-body">
					<form class="" id="filtros{{$randId}}">
							@csrf
							<div class="row" >
								<div class="custom-control my-1 col-md-1 col-sm-12">
									<label class="label text-left" for="codigo_produto">Cód</label>
									<input type="text" name="id" class="form-control form-control-sm filtro" id="codigo_produto">
								</div>

								<div class="custom-control my-1 col-md-2 col-sm-12">
									<label class="label  text-left" for="nome_produto">Nome produto</label>
									<input type="text" name="nome_produto" class="form-control form-control-sm filtro" id="nome_produto">
								</div>

								<div class="custom-control my-1 col-md-1 col-sm-12">
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

								<div class="custom-control my-1 col-md-1 col-sm-12">
									<label class="label  text-left" for="limite">Limite</label>
									<input type="number" value="150" name="limite" class="form-control form-control-sm filtro" id="limite">
								</div>

							</div>
						
					</form>
				</div>

				<div class="card-footer bg-white form-inline">
					<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="form_search_produto{{$randId}}"><i class="fas fa-search"></i> Pesquisar</buttom>
					<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="exportar_relatorio{{$randId}}">Exportar para excel</buttom>
					<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="relatorio{{$randId}}">Relatório</buttom>
					<a href="{{route('ncm.create')}}" onClick="cadastrar{{$randId}}(this);" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="cadastrar{{$randId}}"><i class="fas fa-plus"></i> Cadastrar</a>
					
				</div>

			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="col-md-12 col-sm-12">	
			<div id="response-request{{$randId}}">

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

		@php 
			
			if(! isset($modifyUrlTitle)){

				@endphp
					Utilitarios.modifyUrlWithoutReload('/ncm/head', 'Ncm')
				@php
			}
		@endphp
		
		let idModalOptions = null;
		
		$('html body').delegate('#form_filtro{{$randId}}', 'click', function(ev){
			ev.preventDefault();
			Utilitarios.toggleFiltro();
		});

		//lista os produtos cadastrados
		$('body').delegate('div.card #form_search_produto{{$randId}}', 'click', function(ev){


			ev.preventDefault();
			
			pesquisar{{$randId}}();

		});

		function pesquisar{{$randId}}(){
			let url = '/ncm/index';

			let objResponse = 'div#response-request{{$randId}}';
			//Utilitarios.assistentAjax('GET',url, 'HTML', objResponse)
			togleFiltros();
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

		//cadastra um produto view
		/*$('body').delegate('div.card a#cadastrar{{$randId}}', 'click', function(ev){

			ev.preventDefault();
			let url = $(this).attr('href');

			Utilitarios.assistentAjaxModal('GET',url, 'HTML','NCM-Cadastrar', 'sm', 'auto')
			Utilitarios.toggleFiltro();

		});*/

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
				Utilitarios.toggleFiltro();
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

				let token = $('html').find('#lista{{$randId}}').find('input[name="_token"]').val()
				data.append('_token', token)

				Utilitarios.assistentAjaxModal('POST',url, 'HTML','NCM-Editar', 'sm', '300px', null, data)
			}catch(ex){
					console.log('Erro: '+ex.message);
			}
		}


	</script>