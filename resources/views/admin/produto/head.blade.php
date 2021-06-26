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
				<li class="breadcrumb-item desable" aria-current="page"><a >Lista de produtos</a></li>
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

							<div class="custom-control my-1 col-md-2 col-sm-12">
								<label class="label  text-left" for="marca_produto">Marca</label>
								<input type="text" name="marca_produto" class="form-control form-control-sm filtro" id="marca_produto">
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
				<a href="{{route('produto.create')}}" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="cadastrar_produto{{$randId}}"><i class="fas fa-plus"></i> Cadastrar</a>
			</div>

		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="col-md-12">	
		<div id="response-request">

		</div>
	</div>
</div>
<script type="text/javascript">

	let idModalOptions = null;
	/**
	*	CHAMA O MODAL DE OPÇÕES DE PRODUTO
	*/
	$('body').delegate('.assistenteModalProduto', 'click', function(ev){

		let id = $(this).find('input:hidden').val();

		$.ajax({
			type:'POST',
			url: '#',
			data:true,
			dataType: 'HTML',
			success: function(response){
				console.log(response)
			}
		})
		
		let arrLinks = [
			//['Ediar', '/produto/edit/'+id+'', 'btn btn-lg btn-outline-primary', 'id_produto_editar'],
			['Ediar', '/produto/show/'+id+'', 'btn btn-lg btn-outline-primary', 'id_produto_editar{{$randId}}'],
			['Excluir', '/produto/info/'+id+'', 'btn btn-lg btn-outline-primary', 'id_produto_deletar{{$randId}}'],
			

		];
		//widthOptions='200px', widModal = 'md', height=null //, 'HTML','Marca-Editar', 'sm', '400px'
		idModal = Utilitarios.assitentOpcoes(arrLinks, '100%', 'xs');
		idModalOptions = idModal;
	})


	

	//edita um produto específico view
	$('body').delegate('#id_produto_editar{{$randId}}', 'click', function(ev){


		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.fecharAssistente(idModalOptions);
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Editar', 'sm', '700px')

	});

	//cadastra um produto view
	$('body').delegate('div.card a#cadastrar_produto{{$randId}}', 'click', function(ev){

		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Cadastrar', 'sm', 'auto')
		Utilitarios.toggleFiltro();

	});

	//deletar produto preview
	$('body').delegate('#assistenteModal #id_produto_deletar{{$randId}}', 'click', function(ev){

		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.fecharAssistente(idModalOptions);
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')

	});

	//deleta um produto action
	$('body').delegate('#assistenteModal #id_produto_destroy{{$randId}}', 'click', function(ev){

		try{

			ev.preventDefault();

			let url = $(this).attr('href');
			
			Utilitarios.fecharAssistente(idModalOptions);
			Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md', '500px')

		}catch(ex){
			console.log('Erro: '+ex.message);
		}
		

	});

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

						if(id == 'form_produto_atualizar'){

							Utilitarios.assistenteMensageAlert('Produto atualizado com sucesso');

						}else{

							Utilitarios.assistenteMensageAlert('Produto cadastrado com sucesso');

						}

					}else{

						if(id == 'form_produto_atualizar'){

							Utilitarios.assistenteMensageAlert('Erro ao atuaolizar registro', 'warning');

						}else{

							Utilitarios.assistenteMensageAlert('Erro ao cadastrar registro', 'warning');

						}

						
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


	$('html body').delegate('#form_filtro{{$randId}}', 'click', function(ev){
		ev.preventDefault();
		Utilitarios.toggleFiltro();
	});

	//lista os produtos cadastrados
	$('body').delegate('div.card #form_search_produto{{$randId}}', 'click', function(ev){


		ev.preventDefault();
		let url = '/produto/index/post';

		let objResponse = $('html body').find('div#response-request');
		//Utilitarios.assistentAjax('GET',url, 'HTML', objResponse)
		togleFiltros();
		 carregarItens{{$randId}}('POST', url, 'HTML', objResponse)
		

	});

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