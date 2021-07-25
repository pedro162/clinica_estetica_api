@extends('layouts.app')
@section('content')

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
					<li class="breadcrumb-item desable" aria-current="page"><a >Lista de marcas</a></li>
				</ol>
			</nav>
		</div>
		<div class="col-md-12" id="container_filtros{{$randId}}">
				<div class="card card-togle">
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
								<div class="custom-control my-1 col-md-2 col-sm-12">
									<label class="label text-left" for="codigo_marca">Cód</label>
									<input type="text" name="codigo_marca" class="form-control form-control-sm filtro" id="codigo_marca">
								</div>

								<div class="custom-control my-1 col-md-2 col-sm-12">
									<label class="label text-left" for="nome_marca">Nome marca</label>
									<input type="text" name="nome_marca" class="form-control form-control-sm filtro" id="nome_marca">
								</div>
							</div>
						</form>
					</div>
					<div class="card-footer bg-white form-inline">
						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="form_search_marca{{$randId}}"><i class="fas fa-search"></i> Pesquisar</buttom>
						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="exportar_relatorio{{$randId}}">Exportar para excel</buttom>
						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="relatorio{{$randId}}">Relatório</buttom>
						<a href="{{route('marca.create')}}" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="cadastrar_marca{{$randId}}"><i class="fas fa-plus"></i> Cadastrar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="col-md-12">	
			<div id="response-request{{$randId}}">

			</div>
		</div>
	</div>
	<script type="text/javascript">
		let idModalOptions = null;
		
		$('html body').delegate('#form_filtro{{$randId}}', 'click', function(ev){
			ev.preventDefault();
			Utilitarios.toggleFiltro();
		});
		
		//lista as marcas cadastrados
		$('body').delegate('div.card #form_search_marca{{$randId}}', 'click', function(ev){


			ev.preventDefault();
			pesquisar{{$randId}}()

		});


		//cadastra uma marca
		$('body').delegate('div.card a#cadastrar_marca{{$randId}}', 'click', function(ev){

			ev.preventDefault();
			let url = $(this).attr('href');

			Utilitarios.assistentAjaxModal('GET',url, 'HTML','Marca-Cadastrar')
			Utilitarios.toggleFiltro();

		});


		function pesquisar{{$randId}}(){
			let url = '/marca/index/post';

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

				if(valor.length > 0){
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

		
	</script>
@endsection

