@extends('layouts.app')
@section('content')
@php $randId = rand(11111, 999999); @endphp
<div class="container-fluid my-4">
	<div class="col-md-12">	
		<nav aria-label="breadcrumb" class="my-2">
			<ol class="breadcrumb">
				<li class="breadcrumb-item active"><a href="{{route('produto.index')}}">Inicio</a></li>
				<li class="breadcrumb-item desable" aria-current="page"><a >Lista de produtos</a></li>
			</ol>
		</nav>
	</div>
	<div class="col-md-12">
		<div class="card card-togle">

			<div class="card-header bg-white form-inline">

				<button type="button" class="btn btn-sm btn-outline-primary mb-sm-1" id="form_filtro{{$randId}}"><i class="fas fa-filter"></i></button>
			</div>

			<div class="card-body">
				<form class="form-inline">

					<div class="custom-control my-1 mr-sm-2">
						<label class="label text-left" for="codigo_produto">Cód</label>
						<input type="text" name="codigo_produto" class="form-control form-control-sm" id="codigo_produto">
					</div>

					<div class="custom-control my-1 mr-sm-2">
						<label class="label  text-left" for="nome_produto">Nome produto</label>
						<input type="text" name="nome_produto" class="form-control form-control-sm" id="nome_produto">
					</div>

					<div class="custom-control my-1 mr-sm-2">
						<label class="label  text-left" for="marca_produto">Marca</label>
						<input type="text" name="marca_produto" class="form-control form-control-sm" id="marca_produto">
					</div>

					<div class="custom-control my-1 mr-sm-2">
						<label class="label  text-left" for="descricao_produto">Destaque</label>
						<input type="text" name="descricao_produto" class="form-control form-control-sm" id="descricao_produto">
					</div>

					<div class="custom-control my-1 mr-sm-2">
						<label class="label  text-left" for="descricao_produto">Descrição</label>
						<input type="text" name="descricao_produto" class="form-control form-control-sm" id="descricao_produto">
					</div>

					<div class="custom-control my-1 mr-sm-2">
						<label class="label  text-left" for="dt_inicio">Dt início</label>
						<input type="date" name="dt_inico" class="form-control form-control-sm" id="dt_inicio">
					</div>

					<div class="custom-control my-1 mr-sm-2">
						<label class="label  text-left" for="dt_fim">Dt fim</label>
						<input type="date" name="dt_fim" class="form-control form-control-sm" id="dt_fim">
					</div>
					
					<div class="custom-control custom-checkbox my-1 mr-sm-2">
						<input type="checkbox" name="ignorar_data" class="custom-control-input" id="ignorar_data">
						<label class="custom-control-label" for="ignorar_data">Ignorar data</label>
					</div>
				</form>
			</div>

			<div class="card-footer bg-white form-inline">
				<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="form_search_produto"><i class="fas fa-search"></i> Pesquisar</buttom>
				<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="exportar_relatorio">Exportar para excel</buttom>
				<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="relatorio">Relatório</buttom>
				<a href="{{route('produto.create')}}" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="cadastrar_produto"><i class="fas fa-plus"></i> Cadastrar</a>
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
			['Ediar', '/produto/edit/'+id+'', 'btn btn-lg btn-outline-success', 'id_produto_editar'],
			['Visualizar', '/produto/show/'+id+'', 'btn btn-lg btn-outline-primary', 'id_produto_visualizar'],
			['Excluir', '/produto/info/'+id+'', 'btn btn-lg btn-outline-danger', 'id_produto_deletar'],
			['Adicionar Ingredite', '/produto/adiconar/ingrediente/'+id+'', 'btn btn-lg btn-outline-primary', 'id_produto_adiconar_ingrediente'],

		];

		Utilitarios.assitentOpcoes(arrLinks);
	})


	

	//edita um produto específico view
	$('body').delegate('#assistenteModal #id_produto_editar', 'click', function(ev){


		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Editar')

	});

	//cadastra um produto view
	$('body').delegate('div.card a#cadastrar_produto', 'click', function(ev){

		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Cadastrar', 'lg')
		Utilitarios.toggleFiltro();

	});

	//deletar produto preview
	$('body').delegate('#assistenteModal #id_produto_deletar', 'click', function(ev){

		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar', 'md')

	});

	//deleta um produto action
	$('body').delegate('#assistenteModal #id_produto_destroy', 'click', function(ev){

		try{

			ev.preventDefault();

			let url = $(this).attr('href');
			
			Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Deletar')

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

	//adiciona ingrediente ao produto específico view
	$('body').delegate('#assistenteModal #id_produto_adiconar_ingrediente', 'click', function(ev){


		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Produto-Adicionar Ingredientes')

	});
	

	$('html body').delegate('#form_filtro{{$randId}}', 'click', function(ev){
		ev.preventDefault();
		Utilitarios.toggleFiltro();
	});

	//lista os produtos cadastrados
	$('body').delegate('div.card #form_search_produto', 'click', function(ev){


		ev.preventDefault();
		let url = '/produto/index';

		let objResponse = $('html body').find('div#response-request');
		Utilitarios.assistentAjax('GET',url, 'HTML', objResponse)

		$('div.card').find('.card-body').toggle('fast');
		$('div.card').find('.card-footer').toggle('fast');

	});



</script>
@endsection