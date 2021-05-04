@extends('layouts.app')
@section('content')
@php $randId = rand(11111, 999999); @endphp
<div class="container-fluid my-4 body">
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
						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="form_search"><i class="fas fa-search"></i> Pesquisar</buttom>
						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="exportar_relatorio">Exportar para excel</buttom>
						<buttom type="buttom" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="relatorio">Relatório</buttom>
						<a href="{{route('produto.create')}}" class="btn btn-md btn-outline-primary mr-2 mb-sm-1" id="cadastrar_produto"><i class="fas fa-plus"></i> Cadastrar</a>
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

	</script>
@endsection