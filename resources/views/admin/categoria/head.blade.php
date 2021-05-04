@extends('layouts.app')
@section('content')
@php $randId = rand(11111, 99999);@endphp
<div class="container-fluid my-4 body">
		<div class="col-md-12">	
			<nav aria-label="breadcrumb" class="my-2">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active"><a href="{{route('produto.index')}}">Inicio</a></li>
					<li class="breadcrumb-item desable" aria-current="page"><a >Lista de categorias</a></li>
				</ol>
			</nav>
		</div>
		<div class="col-md-12">
				<div class="card">
					<div class="card-header bg-white form-inline">

						<button type="button" class="btn btn-sm btn-outline-primary mb-sm-1" id="form_filtro{{$randId}}"><i class="fas fa-filter"></i></button>
					</div>
					<div class="card-body">
						<form class="form-inline">
							<div class="custom-control my-1 mr-sm-2">
								<label class="label text-left" for="codigo_marca">Cód</label>
								<input type="text" name="codigo_marca" class="form-control form-control-sm" id="codigo_categoria">
							</div>
							<div class="custom-control my-1 mr-sm-2">
								<label class="label  text-left" for="nome_categoria">Nome categoria</label>
								<input type="text" name="nome_categoria" class="form-control form-control-sm" id="nome_categoria">
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
						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="form_search_categoria"><i class="fas fa-search"></i> Pesquisar</buttom>
						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="exportar_relatorio">Exportar para excel</buttom>
						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="relatorio">Relatório</buttom>
						<a href="{{route('categoria.create')}}" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="cadastrar_categoria"><i class="fas fa-plus"></i> Cadastrar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row mb-5">
			<div id="response-request">

			</div>
		</div>
	</div>

	<script type="text/javascript">
		$('html body').delegate('#form_filtro{{$randId}}', 'click', function(ev){
			ev.preventDefault();
			Utilitarios.toggleFiltro();
		});

		//lista as categoria cadastradas
		$('body').delegate('div.card #form_search_categoria', 'click', function(ev){


			ev.preventDefault();
			let url = '/categoria/index';

			let objResponse = $('html body').find('div#response-request');
			Utilitarios.assistentAjax('GET',url, 'HTML', objResponse)
			Utilitarios.toggleFiltro();

		});

	</script>
@endsection