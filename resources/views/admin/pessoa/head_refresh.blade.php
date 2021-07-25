@extends('layouts.app')
@section('content')
@php $randId = rand(11111, 999999); @endphp

<div class="container-fluid my-4 body">
		<div class="col-md-12">	
			<nav aria-label="breadcrumb" class="my-2">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active"><a href="{{route('pessoa.index')}}">Inicio</a></li>
					<li class="breadcrumb-item desable" aria-current="page"><a >Lista de pessoas</a></li>
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
								<label class="label text-left" for="codigo_pessoa">Cód</label>
								<input type="text" name="codigo_pessoa" class="form-control form-control-sm" id="codigo_pessoa">
							</div>
							<div class="custom-control my-1 mr-sm-2">
								<label class="label  text-left" for="nome_pessoa">Nome categoria</label>
								<input type="text" name="nome_pessoa" class="form-control form-control-sm" id="nome_pessoa">
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
						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="form_search_pessoa"><i class="fas fa-search"></i> Pesquisar</buttom>

						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="exportar_relatorio">Exportar para excel</buttom>

						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="relatorio">Relatório</buttom>

						<a href="{{route('pessoa.create')}}" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="cadastrar_pessoa"><i class="fas fa-plus"></i> Cadastrar CPF</a>

						<a href="{{route('pessoa.create')}}" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="cadastrar_pessoa"><i class="fas fa-plus"></i> Cadastrar CNPJ</a>
					</div>
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

		let idModalOptions = null;
		/**
	*	CHAMA O MODAL DE OPÇÕES DE PESSOA
	*/
	$('body').delegate('.assistenteModalPessoa', 'click', function(ev){

		let id = $(this).find('input:hidden').val();

		/*$.ajax({
			type:'POST',
			url: '#',
			data:true,
			dataType: 'HTML',
			success: function(response){
				console.log(response)
			}
		})*/

		let arrLinks = [
			['Ediar', '/pessoa/edit/'+id+'', 'btn btn-lg btn-outline-primary', 'id_pessoa_editar'],
			['Visualizar', '/pessoa/show/'+id+'', 'btn btn-lg btn-outline-primary', 'id_pessoa_visualizar'],
			['Excluir', '/pessoa/info/'+id+'', 'btn btn-lg btn-outline-primary', 'id_pessoa_deletar'],
			['Gerar Mensalidade', '/cobranca/receber/mensalidade/'+id+'', 'btn btn-lg btn-outline-primary', 'id_pessoa_gerar_mensalidade{{$randId}}'],
			
		];

		let idModal = Utilitarios.assitentOpcoes(arrLinks);
		idModalOptions = idModal;
	})



	//edita uma pessoa específica view
	$('body').delegate('#id_pessoa_editar', 'click', function(ev){


		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.fecharAssistente(idModalOptions);
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Pessoa-Editar', '700px');


	});

	//cadastra uma pessoa view
	$('body').delegate('div.card a#cadastrar_pessoa', 'click', function(ev){

		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.fecharAssistente(idModalOptions);

		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Pessoa-Cadastrar', 'lg', '700px')
		Utilitarios.toggleFiltro();

	});

	//deletar pessoa preview
	$('body').delegate('#id_pessoa_deletar', 'click', function(ev){

		ev.preventDefault();
		let url = $(this).attr('href');
		
		Utilitarios.fecharAssistente(idModalOptions);
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Pessoa-Deletar', 'md')

	});



	$('html body').delegate('#form_filtro{{$randId}}', 'click', function(ev){
		ev.preventDefault();
		Utilitarios.fecharAssistente(idModalOptions);
		Utilitarios.toggleFiltro();
	});

	//lista os pessoas cadastrados
	$('body').delegate('div.card #form_search_pessoa', 'click', function(ev){


		ev.preventDefault();
		let url = '/pessoa/index';

		let objResponse = $('html body').find('div#response-request{{$randId}}');
		Utilitarios.assistentAjax('GET',url, 'HTML', objResponse)
		Utilitarios.toggleFiltro();

	});

	$('body').delegate('#id_pessoa_gerar_mensalidade{{$randId}}', 'click', function(e){
		e.preventDefault();
		let url = $(this).attr('href');
		Utilitarios.fecharAssistente(idModalOptions);
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Mensalidade-Criar', 'lg', '900px')

	})

	//edita uma pessoa específica view
	$('body').delegate('#id_pessoa_plano_adicionar{{$randId}}', 'click', function(ev){


		ev.preventDefault();
		let url = $(this).attr('href');

		Utilitarios.fecharAssistente(idModalOptions);
		Utilitarios.assistentAjaxModal('GET',url, 'HTML','Pessoa-Plano', 'lg', '900px');


	});

	</script>
@endsection