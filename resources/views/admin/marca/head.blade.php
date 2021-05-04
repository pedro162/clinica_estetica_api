@extends('layouts.app')
@section('content')

@php $randId = rand(11111, 999999); @endphp

<div class="container-fluid my-4 body">
		<div class="col-md-12">	
			<nav aria-label="breadcrumb" class="my-2">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active"><a href="{{route('produto.index')}}">Inicio</a></li>
					<li class="breadcrumb-item desable" aria-current="page"><a >Lista de marcas</a></li>
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
								<label class="label text-left" for="codigo_marca">Cód</label>
								<input type="text" name="codigo_marca" class="form-control form-control-sm" id="codigo_marca">
							</div>

							<div class="custom-control my-1 mr-sm-2">
								<label class="label  text-left" for="nome_marca">Nome marca</label>
								<input type="text" name="nome_marca" class="form-control form-control-sm" id="nome_marca">
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
						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="form_search_marca"><i class="fas fa-search"></i> Pesquisar</buttom>
						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="exportar_relatorio">Exportar para excel</buttom>
						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="relatorio">Relatório</buttom>
						<a href="{{route('marca.create')}}" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="cadastrar_marca"><i class="fas fa-plus"></i> Cadastrar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="col-md-12">	
			<div id="response-request">

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
		$('body').delegate('div.card #form_search_marca', 'click', function(ev){


			ev.preventDefault();
			atualizaRelatorio();

		});

		function atualizaRelatorio( url = '/marca/index'){

			let objResponse = $('html body').find('div#response-request');
			Utilitarios.assistentAjax('GET',url, 'HTML', objResponse)
			Utilitarios.toggleFiltro();
		}



		/**
		*	CHAMA O MODAL DE OPÇÕES DE MARCAS
		*/
		$('body').delegate('.assistenteModalMarca', 'click', function(ev){

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
				['Ediar', '/marca/edit/'+id+'', 'btn btn-lg btn-outline-primary', 'id_marca_editar{{$randId}}'],
				['Visualizar', '/marca/show/'+id+'', 'btn btn-lg btn-outline-primary', 'id_marca_visualizar{{$randId}}'],
				['Excluir', '/marca/info/'+id+'', 'btn btn-lg btn-outline-primary', 'id_marca_deletar{{$randId}}']

			];

			let idModal = Utilitarios.assitentOpcoes(arrLinks, '100%', 'xs');
			idModalOptions = idModal;
		})




		//edita uma marca específica
		$('body').delegate('#id_marca_editar{{$randId}}', 'click', function(ev){


			ev.preventDefault();
			let url = $(this).attr('href');

			Utilitarios.fecharAssistente(idModalOptions);
			Utilitarios.assistentAjaxModal('GET',url, 'HTML','Marca-Editar', 'sm', '400px')

		});

		//cadastra uma marca
		$('body').delegate('div.card a#cadastrar_marca', 'click', function(ev){

			ev.preventDefault();
			let url = $(this).attr('href');

			Utilitarios.assistentAjaxModal('GET',url, 'HTML','Marca-Cadastrar')
			Utilitarios.toggleFiltro();

		});

		//chama o preview de deletar marca
		$('body').delegate('#id_marca_deletar{{$randId}}', 'click', function(ev){

			ev.preventDefault();
			let url = $(this).attr('href');

			Utilitarios.assistentAjaxModal('GET',url, 'HTML','Marca-Deletar')

		});

		//deleta uma marca
		$('body').delegate('#id_marca_destroy{{$randId}}', 'click', function(ev){

			ev.preventDefault();
			let url = $(this).attr('href');

			Utilitarios.assistentAjaxModal('GET',url, 'HTML','Marca-Deletar')

		});

		
	</script>
@endsection

